<?php
class ModelModuleReviews extends Model {
	public function getQuestions($data = array(), $sort = array()) {
		$sql = "SELECT  *
				FROM " . DB_PREFIX . "reviewsnew pq
				INNER JOIN " . DB_PREFIX . "reviewsnew_lang pql
					USING(question_id)
				WHERE 1 = 1
				AND pql.question_text != ''
				AND pql.answer_text != ''
				AND pql.language_id = " . (isset($data['language_id']) ? (int)$data['language_id'] : 1)	
				. (isset($data['displayed']) ? " AND pql.display = 1" : '')
				/*. (isset($data['product_id']) ? " AND pq.product_id = " . (int)$data['product_id'] : '')*/

				. (isset($sort['order_by']) ? " ORDER BY {$sort['order_by']} {$sort['order_way']}" : '')
				. (isset($sort['limit']) ? " LIMIT ".(int)$sort['offset'].', '.(int)($sort['limit']) : '');

		$res = $this->db->query($sql);
		
		// decode needed since oc encodes requests by default 
		foreach ($res->rows as &$row)  {
			$row['question_text'] = htmlspecialchars_decode($row['question_text']);
			$row['answer_text'] = htmlspecialchars_decode($row['answer_text']);
		}
		
		return $res->rows;
	}
	
	public function getQuestionCount($data = array()) {
		$sql = "
			SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "reviewsnew` pq
        	LEFT JOIN `" . DB_PREFIX . "reviewsnew_lang` pql
        		ON (pq.question_id = pql.question_id)
			WHERE 1 = 1
			AND pql.question_text != ''
			AND pql.answer_text != ''
			AND pql.language_id = " . (isset($data['language_id']) ? (int)$data['language_id'] : 1)	
			. (isset($data['displayed']) ? " AND pql.display = 1" : '')
			/*. (isset($data['product_id']) ? " AND pq.product_id = " . (int)$data['product_id'] : '')*/;
        
        $res = $this->db->query($sql);
        
		return $res->row['total'];
	}
	
	public function getLangIdByCode($code) {
		$res = $this->db->query("SELECT language_id FROM `" . DB_PREFIX . "language` WHERE code = '" . $code . "'");
		
		return $res->row['language_id'];
	}

    public function addQuestion($question) {
    	$customer_id = (int)($question["customer_id"]);
    	
    	$product_id = isset($question["product_id"]) ? (int)($question["product_id"]) : 0;
    	if ($product_id) {
			$this->load->model('catalog/product');
			$prod = $this->model_catalog_product->getProduct($product_id);
    		$question['product_name']  = strip_tags(htmlspecialchars_decode($prod['name']));
    	}
    	
    	$customer_language_id = (int)($question["customer_language_id"]);
    	$name = $this->db->escape($question["name"]);
    	$email = $this->db->escape($question["email"]);
    	$question_text = $this->db->escape($question["question_text"]);
    	
        $sql = "INSERT INTO `" . DB_PREFIX . "reviewsnew`
		            (product_id, customer_id, customer_language_id, name, email, create_time)
        		VALUES
					($product_id, $customer_id, $customer_language_id, '$name', '$email', UNIX_TIMESTAMP(NOW()))";
		$this->db->query($sql);
		
		$this->load->model('localisation/language');
		$languages = $this->model_localisation_language->getLanguages();
		
		foreach ($languages as $language) {
	        $sql = "INSERT INTO `" . DB_PREFIX . "reviewsnew_lang`
			            (question_id, language_id, question_text)
	        		VALUES
						(LAST_INSERT_ID(), {$language['language_id']}, '$question_text')";
			$this->db->query($sql);
			
			$langs[$language['code']] = $language;
		}		
		
       	if ($this->config->get('productquestion_conf_email') != '') {
			$language = new Language($langs[$this->config->get('config_admin_language')]['directory']);
			$language->load('module/reviews');
       		
			if ($product_id) {
				$subject = sprintf($language->get('pq_mail_subject'), $this->config->get('config_name'),$question['product_name']);
			} else {
				$subject = sprintf($language->get('pqs_mail_subject'), $this->config->get('config_name'));
			}
			/*$template = new Template();
			if ($product_id) {
				$template->data['mail_text_question_added'] = sprintf($language->get('pq_mail_question_added'), $question['product_name'], $this->config->get('config_name'));
				$template->data['mail_text_product'] = $language->get('pq_mail_product');
				$template->data['product_name'] = $question["product_name"];
				$template->data['product_id'] = $product_id;
				$subject = sprintf($language->get('pq_mail_subject'), $this->config->get('config_name'),$question['product_name']);
			} else {
				$template->data['mail_text_product'] = '';
				$template->data['mail_text_question_added'] = sprintf($language->get('pqs_mail_question_added'), $this->config->get('config_name'));
				$subject = sprintf($language->get('pqs_mail_subject'), $this->config->get('config_name'));
			}
			
			$template->data['mail_text_name'] = $language->get('pq_mail_name');
			$template->data['mail_text_email'] = $language->get('pq_mail_email');
			$template->data['mail_text_question'] = $language->get('pq_mail_question');
			
			$template->data['name'] = htmlspecialchars($question["name"]);
			$template->data['email'] = strip_tags($question["email"]);
			$template->data['question_text'] = htmlspecialchars($question["question_text"]);
			
			$template->data['store_name'] = $this->config->get('config_name');
			$template->data['store_url'] = HTTP_SERVER;
			$template->data['mail_text_answer'] = sprintf($this->language->get('pq_mail_answer'), HTTPS_SERVER . $this->language->get('pq_admin') . '/index.php?route=module/productquestion');*/
			$message = "На сайте tdekor.ru был отправлен новый вопрос\n\n";
			
			$mail = new Mail($this->config->get('config_mail')); 
			/*$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->hostname = $this->config->get('config_smtp_host');
			$mail->username = $this->config->get('config_smtp_username');
			$mail->password = $this->config->get('config_smtp_password');
			$mail->port = $this->config->get('config_smtp_port');
			$mail->timeout = $this->config->get('config_smtp_timeout');*/
			$mail->setTo($this->config->get('productquestion_conf_email'));
			$mail->setFrom($this->config->get('config_email'));
			$mail->setSender($this->config->get('config_name'));
			$mail->setSubject($subject);
			//$mail->setHtml($template->fetch($this->config->get('config_template') . '/template/mail/productquestion.tpl'));
			$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
			$mail->send();
        }
    }    
}
