<?php
class ControllerInformationReviews extends Controller {
	public function index() {
		$this->language->load('information/reviews');
		
		$this->load->model('extension/faq');

		$this->load->model('catalog/review');
	 
		$this->document->setTitle($this->language->get('heading_title')); 
		$this->document->setDescription("Отзывы - Магазин одежды и текстиля Tdekor.ru"); 
	 
		$data['breadcrumbs'] = array();
		
		$data['breadcrumbs'][] = array(
			'text' 		=> $this->language->get('text_home'),
			'href' 		=> $this->url->link('common/home')
		);
		$data['breadcrumbs'][] = array(
			'text' 		=> "Отзывы",
			'href' 		=> $this->url->link('information/faq')
		);
		  
		$url = '';
	 
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		

		//$data['reviews2'] = $this->model_catalog_review->getReviewsALL();

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/faq.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/information/faq.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/information/faq.tpl', $data));
		}
	}
 
	
	
}