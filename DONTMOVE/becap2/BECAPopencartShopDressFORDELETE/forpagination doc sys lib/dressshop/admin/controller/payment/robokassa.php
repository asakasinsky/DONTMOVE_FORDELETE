<?php
class ControllerPaymentRobokassa extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('payment/robokassa');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting('robokassa', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['text_liqpay'] = $this->language->get('text_liqpay');
		$data['text_card'] = $this->language->get('text_card');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');

		$data['entry_login'] = $this->language->get('entry_login');
		$data['entry_password1'] = $this->language->get('entry_password1');
		$data['entry_password2'] = $this->language->get('entry_password2');
		$data['entry_result_url'] = $this->language->get('entry_result_url');
		$data['entry_success_url'] = $this->language->get('entry_success_url');
		$data['entry_fail_url'] = $this->language->get('entry_fail_url');
		$data['entry_test'] = $this->language->get('entry_test');
		$data['entry_order_status'] = $this->language->get('entry_order_status');
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['robokassa_result_url'] = HTTP_CATALOG . 'index.php?route=payment/robokassa/callback';
		$data['robokassa_success_url'] = HTTP_CATALOG . 'index.php?route=payment/robokassa/success';
		$data['robokassa_fail_url'] = HTTP_CATALOG . 'index.php?route=payment/robokassa/fail';

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['login'])) {
			$data['error_login'] = $this->error['login'];
		} else {
			$data['error_login'] = '';
		}

		if (isset($this->error['password1'])) {
			$data['error_password1'] = $this->error['password1'];
		} else {
			$data['error_password1'] = '';
		}

		if (isset($this->error['password2'])) {
			$data['error_password2'] = $this->error['password2'];
		} else {
			$data['error_password2'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_payment'),
			'href' => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('payment/robokassa', 'token=' . $this->session->data['token'], 'SSL')
		);
		
		$data['action'] = $this->url->link('payment/robokassa', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['robokassa_login'])) {
			$data['robokassa_login'] = $this->request->post['robokassa_login'];
		} else {
			$data['robokassa_login'] = $this->config->get('robokassa_login');
		}

		if (isset($this->request->post['robokassa_password1'])) {
			$data['robokassa_password1'] = $this->request->post['robokassa_password1'];
		} else {
			$data['robokassa_password1'] = $this->config->get('robokassa_password1');
		}

		if (isset($this->request->post['robokassa_password2'])) {
			$data['robokassa_password2'] = $this->request->post['robokassa_password2'];
		} else {
			$data['robokassa_password2'] = $this->config->get('robokassa_password2');
		}
		
		if (isset($this->request->post['robokassa_test'])) {
			$data['robokassa_test'] = $this->request->post['robokassa_test'];
		} else {
			$data['robokassa_test'] = $this->config->get('robokassa_test');
		}

		if (isset($this->request->post['robokassa_order_status_id'])) {
			$data['robokassa_order_status_id'] = $this->request->post['robokassa_order_status_id'];
		} else {
			$data['robokassa_order_status_id'] = $this->config->get('robokassa_order_status_id');
		}

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['robokassa_geo_zone_id'])) {
			$data['robokassa_geo_zone_id'] = $this->request->post['robokassa_geo_zone_id'];
		} else {
			$data['robokassa_geo_zone_id'] = $this->config->get('robokassa_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['robokassa_status'])) {
			$data['robokassa_status'] = $this->request->post['robokassa_status'];
		} else {
			$data['robokassa_status'] = $this->config->get('robokassa_status');
		}

		if (isset($this->request->post['robokassa_sort_order'])) {
			$data['robokassa_sort_order'] = $this->request->post['robokassa_sort_order'];
		} else {
			$data['robokassa_sort_order'] = $this->config->get('robokassa_sort_order');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('payment/robokassa.tpl', $data));
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'payment/robokassa')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['robokassa_login']) {
			$this->error['login'] = $this->language->get('error_login');
		}

		if (!$this->request->post['robokassa_password1']) {
			$this->error['password1'] = $this->language->get('error_password1');
		}

		if (!$this->request->post['robokassa_password2']) {
			$this->error['password2'] = $this->language->get('error_password2');
		}

		return !$this->error;
	}
}