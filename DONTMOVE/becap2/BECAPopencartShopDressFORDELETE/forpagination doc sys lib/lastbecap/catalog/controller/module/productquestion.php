<?php
class ControllerModuleProductquestion extends Controller {
	protected  $data;
	
	public function __construct($registry) {
		parent::__construct($registry);		
		$this->registry = $registry;
		$this->data = array_merge(array(), $this->load->language('module/productquestion'));
		$this->load->model('module/productquestion');
		$this->language->load('module/productquestion');		
	}
	
	public function index() {
		$this->document->addScript('catalog/view/javascript/productquestion.js');
		if (file_exists('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/productquestion.css')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/productquestion.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/productquestion.css');
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/productquestion_sidebar.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/productquestion_sidebar.tpl';
		} else {
			$this->template = 'default/template/module/productquestion_sidebar.tpl';
		}		
		
		$this->data['productquestion_conf_maxlen'] = $this->config->get('productquestion_conf_maxlen');
		$this->data['pqsName'] = $this->customer->getFirstname();
		$this->data['pqsEmail'] = $this->customer->getEmail();
		
		$questions_per_page = $this->config->get('productquestion_conf_qpp');
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}  
		
		$langId = $this->model_module_productquestion->getLangIdByCode($this->customer->session->data['language']);
		
		$this->data['pqQuestions'] = $this->model_module_productquestion->getQuestions(
			array(
				'language_id' => $langId,
				'display' => 1,
				'product_id' => 0
			),
			array(
				'order_by' => 'pq.create_time',
				'order_way' => 'DESC',
				'offset' => ($page - 1) * $questions_per_page,
				'limit' => $questions_per_page
			)
		);
		
		$total_questions = $this->model_module_productquestion->getQuestionCount(
			array(
				'language_id' => $langId,
				'display' => 1,
				'product_id' => 0
			)
		);
      		
		$pagination = new MyPagination();
		$pagination->total = $total_questions;
		$pagination->page = $page;
		$pagination->limit = $questions_per_page; 
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('information/faq', '&page={page}');
			
		$this->data['pagination'] = $pagination->render();
		
		//$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
		return $this->load->view($this->template , $this->data);
	}
	
	public function getForm() {
		$language_id = $this->model_module_productquestion->getLangIdByCode($this->customer->session->data['language']);
		$product_id = $this->request->get['product_id'];
		$questions_per_page = $this->config->get('productquestion_conf_qpp');
		$page = (isset($this->request->get['page'])) ? (int)$this->request->get['page'] : 1;
		
		$this->data['product_id'] = $product_id;
		
		$this->data['pqQuestions'] = $this->model_module_productquestion->getQuestions(
			array(
				'language_id' => $language_id,
				'display' => 1,
				'product_id' => $product_id
			),
			array(
				'order_by' => 'pq.create_time',
				'order_way' => 'DESC',
				'offset' => ($page - 1) * $questions_per_page,
				'limit' => $questions_per_page
			)
		);
		
		$total_questions = $this->model_module_productquestion->getQuestionCount(
			array(
				'language_id' => $language_id,
				'display' => 1,
				'product_id' => $product_id
			)
		);
		
		$pagination = new Pagination();
		$pagination->total = $total_questions;
		$pagination->page = $page;
		$pagination->limit = $questions_per_page; 
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('product/product', "&product_id=$product_id&page={page}");
			
		$this->data['pagination'] = $pagination->render();
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/productquestion.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/productquestion.tpl';
		} else {
			$this->template = 'default/template/module/productquestion.tpl';
		}			
					
		$this->load->model('catalog/product');
		$prod = $this->model_catalog_product->getProduct($this->request->get['product_id']);
		$this->data['pq_ask'] = sprintf($this->language->get('pq_ask'),$prod['name']);
		
		$this->data['productquestion_conf_maxlen'] = $this->config->get('productquestion_conf_maxlen');
		$this->data['pqName'] = $this->customer->getFirstname();
		$this->data['pqEmail'] = $this->customer->getEmail();

		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}	
	
	public function submitProductQuestion() {
		if (!isset($this->request->get['product_id']))
			return;
		
		$json = array();
		$question['product_id'] = $this->request->get['product_id'];
		
		// product form
		$question['name'] = trim(strip_tags(htmlspecialchars_decode($this->request->post['pqName'])));
		$question['email'] = trim(strip_tags(htmlspecialchars_decode($this->request->post['pqEmail'])));
		$question['question_text'] = trim(strip_tags(htmlspecialchars_decode($this->request->post['pqText'])));
		$question['customer_language_id'] = $this->model_module_productquestion->getLangIdByCode($this->customer->session->data['language']);
		$question['customer_id'] = ($this->customer->isLogged()) ? $this->customer->getId() : 0;
		
		
		if (!isset($this->request->post['captcha']) || empty($question['question_text']) || empty($question['name']) || empty($question['email'])) {
			$json['errors'][] = $this->language->get('pqs_error_all_required');
		} else {
			if ($this->session->data['captcha'] != $this->request->post['captcha']) {
				$json['errors'][] = $this->language->get('pq_error_captcha');
			}

			if (mb_strlen($question['question_text'],'UTF-8') > $this->config->get('productquestion_conf_maxlen')
			&& $this->config->get('productquestion_conf_maxlen') > 0) {
				$json['errors'][] = $this->language->get('pq_error_text');
			}
	
			if (!filter_var($question['email'], FILTER_VALIDATE_EMAIL) || mb_strlen($question['email'], 'UTF-8') > 128) {
				$json['errors'][] = $this->language->get('pq_error_email');
			}
			
			if (mb_strlen($question['name'],'UTF-8') < 3 || mb_strlen($question['name'],'UTF-8') > 25) {
				$json['errors'][] = $this->language->get('pq_error_name');
			}
		}
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && !isset($json['errors'])) {
			$this->model_module_productquestion->addQuestion($question);
			$json['success'] = $this->language->get('pq_success');
		}
		
		if (strcmp(VERSION,'1.5.1.3') >= 0) {
			$this->response->setOutput(json_encode($json));
		} else {
			$this->load->library('json');
			$this->response->setOutput(Json::encode($json));			
		}		
	}
	
	public function submitQuestion() {
		$json = array();
		
	    $question['name'] = trim(strip_tags(htmlspecialchars_decode($this->request->post['pqsName'])));
	    $question['email'] = trim(strip_tags(htmlspecialchars_decode($this->request->post['pqsEmail'])));
	    $question['question_text'] = trim(strip_tags(htmlspecialchars_decode($this->request->post['pqsText'])));
	    $question['customer_language_id'] = $this->model_module_productquestion->getLangIdByCode($this->customer->session->data['language']);
	    $question['customer_id'] = ($this->customer->isLogged()) ? $this->customer->getId() : 0;
		
		if (empty($question['question_text']) || empty($question['name']) || empty($question['email'])) {
			$json['errors'][] = $this->language->get('pqs_error_all_required');
		} else {
			if (mb_strlen($question['question_text'],'UTF-8') > $this->config->get('productquestion_conf_maxlen')
			&& $this->config->get('productquestion_conf_maxlen') > 0) {
				$json['errors'][] = $this->language->get('pqs_error_text_long');
			}

			if (!filter_var($question['email'], FILTER_VALIDATE_EMAIL) || mb_strlen($question['email'], 'UTF-8') > 128) {
				$json['errors'][] = $this->language->get('pqs_error_email');
			}
			
			if (mb_strlen($question['name'],'UTF-8') < 3 || mb_strlen($question['name'],'UTF-8') > 25) {
				$json['errors'][] = $this->language->get('pqs_error_name');
			}
		}
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && !isset($json['errors'])) {
			$this->model_module_productquestion->addQuestion($question);
			$json['success'] = $this->language->get('pqs_success');
		}
		
		if (strcmp(VERSION,'1.5.1.3') >= 0) {
			$this->response->setOutput(json_encode($json));
		} else {
			$this->load->library('json');
			$this->response->setOutput(Json::encode($json));			
		}
	}
	
	public function questions() {
		$questions_per_page = $this->config->get('productquestion_conf_qpp');
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}  
		
		$langId = $this->model_module_productquestion->getLangIdByCode($this->customer->session->data['language']);
		
		$this->data['pqQuestions'] = $this->model_module_productquestion->getQuestions(
			array(
				'language_id' => $langId,
				'display' => 1,
				'product_id' => 0
			),
			array(
				'order_by' => 'pq.create_time',
				'order_way' => 'DESC',
				'offset' => ($page - 1) * $questions_per_page,
				'limit' => $questions_per_page
			)
		);
		
		$total_questions = $this->model_module_productquestion->getQuestionCount(
			array(
				'language_id' => $langId,
				'display' => 1,
				'product_id' => 0
			)
		);
      		
		$pagination = new Pagination();
		$pagination->total = $total_questions;
		$pagination->page = $page;
		$pagination->limit = $questions_per_page; 
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('module/productquestion/questions', '&page={page}');
			
		$this->data['pagination'] = $pagination->render();
		
		if (file_exists('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/productquestion.css')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/productquestion.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/productquestion.css');
		}
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/productquestion_list.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/productquestion_list.tpl';
		} else {
			$this->template = 'default/template/module/productquestion_list.tpl';
		}

		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
       		'separator' => false
   		);			
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('pq_questions_title'),
			'href'      => $this->url->link('module/productquestion/questions'),
       		'separator' => ' » '
   		);				
		
		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'
		);
		
		$this->document->setTitle($this->language->get('pq_questions_title'));		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}	
}
?>