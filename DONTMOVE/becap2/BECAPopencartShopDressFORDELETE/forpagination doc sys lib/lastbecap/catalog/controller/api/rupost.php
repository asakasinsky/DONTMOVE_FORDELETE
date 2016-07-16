<?php
class ControllerApiRupost extends Controller {
	public $ECHO = true;
	public $LOG_LEVEL = 4;
	public $CONFIG = array(
		'login'=>'',
		'password'=>'',
		'corporate'=>0,
		'period'=>0.1,
		'Timezone_diff'=>4,
		'shipping_code'=>'',
		'last_hours'=>-1,
		'delivery_status'=>2,
		'returning_status'=>8,
		'delivered_status'=>3,
		'returned_status'=>13,
		'ok_status'=>5,
		'fail_status'=>10,
		'skip_inessential'=>0,
		
		'start_text'=>"Уважаемый {firstname}, ваш заказ №{order_id} передан почте России, отделение почтовой связи '{WHERE}'. Код почтового отправления: {track_no}.",
		'start_notify'=>1,
		'start_sms'=>"{firstname}, ваш заказ #{order_id} передан почте России '{WHERE}'. Код отправления: {track_no}.",
		'start_sms_notify'=>1,
		'delivered_text'=>"Уважаемый {firstname}, ваш заказ №{order_id} прибыл в отделение почтовой связи '{WHERE}'. Код почтового отправления: {track_no}.",
		'delivered_notify'=>1,
		'delivered_sms'=>"{firstname}, ваш заказ #{order_id} прибыл в почтовое отделение '{WHERE}'. Код отправления: {track_no}.",
		'delivered_sms_notify'=>1,
		'returning_text'=>"Уважаемый {firstname}, заказ №{order_id} не был вами получен в отделении почтовой связи '{WHERE}'. Почта начала возврат заказа отправителю.",
		'returning_notify'=>1,
		'ok_text'=>"Уважаемый {firstname}, спасибо за покупку в нашем магазине.",
		'ok_notify'=>0,
		
		'text'=>"изменен статус почтового отправления. Новый статус: {WHERE}, {STATUS}",
		'notify'=>1
	);

	private function setConfig() {
		if ($this->config->get('rupostupd_set')) {
			foreach($this->CONFIG as $key=>$conf) {
				$this->CONFIG[$key] = $this->config->get('rupostupd_'.$key);
			}
		}
	}

	public function update() {
		$this->setConfig();
    	$this->language->load('sale/order');
	
		if (isset($_SERVER['HTTP_HOST'])) {
			header("Content-Type: text/html; charset=utf-8");
		}
		$this->log('RussianPost-tracking Started', 3);
		if (!$this->config->get('rupostupd_status')) {
			$this->log('Модуль "Автотреккинг доставок Почты России" отключен', 3);
			return false;
		}
		
		//include the library
		require_once(DIR_SYSTEM . 'library/russianpost.lib.php');

		$orders = $this->getOrdersToUpdate();
		foreach ($orders as $order) {
            if (!preg_match('/\w\w\d{9}\w\w/i', $order['track_no']) && !preg_match('/\d{14}/i', $order['track_no'])) {
                continue;
            }
			try {
				//init the client
				$client = new RussianPostAPI($this->config->get('rupostupd_login'), $this->config->get('rupostupd_password'));

				//fetch info
				$state = $client->getOperationHistory($order['track_no']);
				
				$query = $this->db->query("SELECT comment FROM `".DB_PREFIX."order_history` WHERE order_id='".(int)$order['order_id']."' ORDER BY date_added DESC");
				$this->handleStatus($order, $state, $query->rows);
			} catch(RussianPostException $e) {
				$this->log('Заказ #'.$order['track_no'].' (ID:'.$order['order_id'].') Ошибка сервиса Почты России: ' . $e->getMessage(), 0);
			}
		}
		$this->log('RussianPost-tracking Finished', 3);
	}
	
	protected function getOrdersToUpdate() {
		$shipping_code = $this->config->get('rupostupd_shipping_code');
		$shcode_where = ($shipping_code ? " AND o.shipping_code LIKE '" . $shipping_code . "%'" : '');
		$not_in = ($this->config->get('rupostupd_order_statuses') ? $this->config->get('rupostupd_order_statuses') : '0');
		$limit = $this->config->get('rupostupd_corporate') ? 3000 : 100;
		$query = $this->db->query("SELECT o.*
			FROM `" . DB_PREFIX . "order` o
			LEFT JOIN `" . DB_PREFIX . "order_history` h ON (o.order_id=h.order_id AND h.date_added>'" . date('Y-m-d H:i:s', time()-($this->CONFIG['period']*3600)) ."')
			WHERE o.track_no <> '' AND h.order_history_id IS NULL $shcode_where AND o.order_status_id <> '0' AND NOT(o.order_status_id IN($not_in)) ORDER BY h.date_added DESC LIMIT $limit");
		return $query->rows;
	}
	
	private function parseDate($str) {
		$date = date_parse($str);
		return date('d.m.Y H:i:s', mktime( $date['hour'], $date['minute'], $date['second'], $date['month'], $date['day'], $date['year']));
	}
	
	private function handleStatus($order, $state, $comments) {
		$this->load->model('checkout/order');
		$return = false;
		foreach ($state as $s) {
			$s = (array) $s;
			
			$this->log('Заказ #'.$order['track_no'].' (ID:'.$order['order_id'].'). Обрабатываем данные '.json_encode($s).'.', 5);

			//Возвращается
			if ($s['operationTypeId'] == 3) {
				$return = true;
			}
			//Отсекаем старые треккинги 2-летней давности
			$date = date_parse($s['operationDate']);
			if (intval(date('Y')) - intval($date['year']) > 2) {
				$this->log('Order #'.$order['track_no'].' (ID:'.$order['order_id'].'), status is too old: ' . $s['operationDate'] . '.', 3);
				continue;
			}
			
			$already_added = false;
			foreach($comments as $row) {
				if (strpos($row['comment'], $this->parseDate($s['operationDate'])) === 0) {
					$already_added = true;
				}
			}
			if ($already_added) {
				$this->log('Заказ #'.$order['track_no'].' (ID:'.$order['order_id'].'). Данные уже обработаны ранее.', 4);
				continue;
			}
			
			$notify = false;
			 //Принята почтой
			if ($s['operationTypeId'] == 1) {
				$status = $this->CONFIG['delivery_status'];
				$notify = $this->CONFIG['start_notify'];
				$notify_text = $this->getComment($order, $s, $this->CONFIG['start_text']);
				if ($this->CONFIG['start_sms_notify']) {
					$msg = $this->getComment($order, $s, $this->CONFIG['start_sms']);
					$this->smsNotify($order, $msg);
				}
			}
			 //Доставлена
			elseif (!$return && ($s['operationTypeId'] == 8) && ($s['operationAttributeId'] == 2)) {
				$status = $this->CONFIG['delivered_status'];
				$notify = $this->CONFIG['delivered_notify'];
				$notify_text = $this->getComment($order, $s, $this->CONFIG['delivered_text']);
				if ($this->CONFIG['delivered_sms_notify']) {
					$msg = $this->getComment($order, $s, $this->CONFIG['delivered_sms']);
					$this->smsNotify($order, $msg);
				}
			}
			 //Неудачная попытка вручения - Адресат заберет отправление сам
			elseif (!$return && ($s['operationTypeId'] == 12) && ($s['operationAttributeId'] == 9 || $s['operationAttributeId'] == 1)) {
				$status = $this->CONFIG['delivered_status'];
			}
			 //Возвращается
			elseif ($s['operationTypeId'] == 3) {
				$status = $this->CONFIG['returning_status'];
				$notify = $this->CONFIG['returning_notify'];
				$notify_text = $this->getComment($order, $s, $this->CONFIG['returning_text']);
			}
			 //Вручена
			elseif (!$return && $s['operationTypeId'] == 2) {
				$status = $this->CONFIG['ok_status'];
				$notify = $this->CONFIG['ok_notify'];
				$notify_text = $this->getComment($order, $s, $this->CONFIG['ok_text']);
			}
			 //Вернулась
			elseif ($return && ($s['operationTypeId'] == 8) && ($s['operationAttributeId'] == 2)) {
				$status = $this->CONFIG['returned_status'];
			}
			 //Вручен отправителю
			elseif ($return && $s['operationTypeId'] == 2) {
				$status = $this->CONFIG['fail_status'];
			}
			else {
				$status = ($return ? $this->CONFIG['returning_status'] : $this->CONFIG['delivery_status']);
				if ($this->CONFIG['skip_inessential']) {
					$this->log('Заказ #'.$order['track_no'].' (ID:'.$order['order_id'].'). Пропускаем несущественный статус: '.$s['operationPlaceName'].', '.$s['operationDate'].' '.$s['operationType'].($s['operationAttribute'] ? ' - '.$s['operationAttribute'] : ''), 3);
					continue;
				}
			}
		
			try {
				$date = $this->parseDate($s['operationDate']);
				$comment = $this->getComment($order, $s, $date.' '.$this->CONFIG['text']);
				$this->model_checkout_order->addOrderHistory($order['order_id'], $status, $comment, false, true);
				$this->log('Заказ #'.$order['track_no'].' (ID:'.$order['order_id'].'). Добавлена история заказа: '.$comment, 3);
				if ($notify) {
					$this->model_checkout_order->addOrderHistory($order['order_id'], $status, $comment, true, true);
					$this->log('Заказ #'.$order['track_no'].' (ID:'.$order['order_id'].'). Покупатель уведомлен: '.$notify_text, 3);
				}
			} catch (Exception $e) {
				$this->log('Заказ #'.$order['track_no'].' (ID:'.$order['order_id'].'). Ошибка добавления истории заказа ('.$e->getMessage().').', 1);
			}
		}
	}

	protected function smsNotify($order, $message) {
		if ($this->config->get('config_sms_alert')) {
			$options = array(
				'to'       => $order['telephone'],
				'copy'     => '',
				'from'     => $this->config->get('config_sms_from'),
				'username'    => $this->config->get('config_sms_gate_username'),
				'password' => $this->config->get('config_sms_gate_password'),
				'message'  => $message,
				'ext'      => null
			);
			
			$this->load->library('sms');

			$sms = new Sms($this->config->get('config_sms_gatename'), $options);
			$sms->send();
			$this->log('Заказ #'.$order['track_no'].' (ID:'.$order['order_id'].'). Отправляем SMS, тел.: ' . $order['telephone'] . ' (' . $message . ').', 4);
		}
	}
	
	private function getComment($order, $state, $text) {
		foreach ($order as $key=>$val) {
			$text = str_replace('{'.$key.'}', $val, $text);
		}
		$text = str_replace('{WHERE}', $state['operationPlaceName'], $text);
		$text = str_replace('{STATUS}', $state['operationType'].($state['operationAttribute'] ? ' - '.$state['operationAttribute'] : ''), $text);
		return $text;
	}
	
	/**
	* Писать в журнал ошибки и сообщения
	* @param str $msg запись
	* @param int $level приоритет ошибки/сообщения. Если приоритет больше $this->LOG_LEVEL, то он записан не будет
	**/
	private function log($msg, $level = 0) {
		if ($level > $this->LOG_LEVEL) return;
		$fp = fopen(DIR_LOGS.'rupost_updater.log', 'a');
		fwrite($fp, date('Y-m-d H:i:s').': '.str_replace("\n", '', $msg)."\n");
		if ($this->ECHO) echo nl2br(htmlspecialchars($msg))."<br/>\n";
		fclose($fp);
	}
}