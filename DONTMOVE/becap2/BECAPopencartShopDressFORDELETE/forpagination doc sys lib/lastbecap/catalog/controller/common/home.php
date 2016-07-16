<?php
class ControllerCommonHome extends Controller {
	public function index() {
		$this->document->setTitle($this->config->get('config_meta_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));
		$this->document->setKeywords($this->config->get('config_meta_keyword'));
                $this->document->addScript(HTTP_SERVER . '/catalog/view/javascript/banner_html5/easeljs-0.8.1.min.js');
                $this->document->addScript(HTTP_SERVER . '/catalog/view/javascript/banner_html5/tweenjs-0.6.1.min.js');
                $this->document->addScript(HTTP_SERVER . '/catalog/view/javascript/banner_html5/movieclip-0.8.1.min.js');
                $this->document->addScript(HTTP_SERVER . '/catalog/view/javascript/banner_html5/preloadjs-0.6.1.min.js');
                $this->document->addScript(HTTP_SERVER . '/catalog/view/javascript/banner_html5/1170x326html5.js');

		if (isset($this->request->get['route'])) {
			$this->document->addLink(HTTP_SERVER, 'canonical');
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/home.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/common/home.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/common/home.tpl', $data));
		}
	}
}