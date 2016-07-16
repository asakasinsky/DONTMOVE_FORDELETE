<?php

class ControllerModuleAlsobought extends Controller {

	private $error = array(); 

	public function index() {   

	   $this->language->load('module/alsobought');
       $this->load->model('module/alsobought');
       $this->load->model('setting/store');

	   $this->document->setTitle($this->language->get('heading_title'));
	   $this->load->model('setting/setting');
	   $this->document->addStyle('view/stylesheet/alsobought.css');	

	   if(!isset($this->request->get['store_id'])) {
          $this->request->get['store_id'] = 0; 
       }
       $store = $this->getCurrentStore($this->request->get['store_id']);

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			if (!$this->user->hasPermission('modify', 'module/alsobought')) {
				$this->validate();
				$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
			}

			if (!empty($_POST['OaXRyb1BhY2sgLSBDb21'])) {
				$this->request->post['alsobought']['LicensedOn'] = $_POST['OaXRyb1BhY2sgLSBDb21'];
			}

			if (!empty($_POST['cHRpbWl6YXRpb24ef4fe'])) {
				$this->request->post['alsobought']['License'] = json_decode(base64_decode($_POST['cHRpbWl6YXRpb24ef4fe']),true);
			}


           $this->model_module_alsobought->editSetting('alsobought', $this->request->post, $this->request->post['store_id']);

			$this->session->data['success'] = $this->language->get('text_success');

           $this->response->redirect($this->url->link('module/alsobought', 'store_id='.$this->request->post['store_id'] . '&token=' . $this->session->data['token'], 'SSL'));

			

			if (!empty($_GET['activate'])) {

				$this->session->data['success'] = $this->language->get('text_success_activation');

			}

			

			$selectedTab = (empty($this->request->post['selectedTab'])) ? 0 : $this->request->post['selectedTab'];
           $this->response->redirect($this->url->link('module/alsobought', 'token=' . $this->session->data['token'] . '&tab='.$selectedTab, 'SSL'));

		}

		

		$alsoBoughtStats = $this->db->query("SELECT * FROM `" . DB_PREFIX . "alsobought` ORDER BY `number` DESC LIMIT 100");

		

		$data['alsoBoughtStats'] = $alsoBoughtStats->rows;

		

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		foreach ($data['alsoBoughtStats'] as $k=>$v) {

			$data['alsoBoughtStats'][$k]['highProduct'] = $this->model_catalog_product->getProduct($v['high']);	

			$data['alsoBoughtStats'][$k]['highProduct']['image'] = $this->model_tool_image->resize($data['alsoBoughtStats'][$k]['highProduct']['image'], 80, 80);

			$data['alsoBoughtStats'][$k]['lowProduct'] = $this->model_catalog_product->getProduct($v['low']);	

			$data['alsoBoughtStats'][$k]['lowProduct']['image'] = $this->model_tool_image->resize($data['alsoBoughtStats'][$k]['lowProduct']['image'], 80, 80);

		}

	

	
       $languageVariables = array(

		    // Main

			'heading_title',
			'error_permission',
			'text_success',
			'text_enabled',
			'text_disabled',
			'button_cancel',
			'save_changes',
			'text_default',
			'text_module',
			// Control panel
           'entry_code',

			'entry_code_help',
           'text_content_top', 
           'text_content_bottom',
           'text_column_left', 
           'text_column_right',
           'entry_layout',         
           'entry_position',       
           'entry_status',         
           'entry_sort_order',     
           'entry_layout_options',  
           'entry_position_options',

			'entry_action_options',
           'button_add_module',
           'button_remove',

			// Custom CSS

			'custom_css',
           'custom_css_help',
           'custom_css_placeholder',

			// Module depending

			'wrap_widget',
			'wrap_widget_help',
			'text_products',
			'text_products_help',
			'text_image_dimensions',
			'text_image_dimensions_help',
			'text_pixels',
			'text_panel_name',
			'text_panel_name_help',
			'text_products_small',
			'show_add_to_cart',
			'show_add_to_cart_help',
			'custom_positioning',
			'custom_positioning_below',
			'custom_positioning_no',	
       );
      
       foreach ($languageVariables as $languageVariable) {
           $data[$languageVariable] = $this->language->get($languageVariable);
       }

		

		$this->load->model('localisation/language');

		$languages = $this->model_localisation_language->getLanguages();;

		$data['languages'] = $languages;

		$firstLanguage = array_shift($languages);

		$data['firstLanguageCode'] = $firstLanguage['code'];

		
		 if (isset($this->session->data['success'])) {     
           $data['success'] = $this->session->data['success'];
           unset($this->session->data['success']);
       } else {
           $data['success'] = '';
       }
       
       if (isset($this->error['warning'])) { 
           $data['error_warning'] = $this->error['warning'];
       } else {
           $data['error_warning'] = '';
       }

		

		

		$data['breadcrumbs'] = array();
  		$data['breadcrumbs'][] = array(
      		'text'      => $this->language->get('text_home'),

			'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
     		'separator' => false
  		);
  		$data['breadcrumbs'][] = array(
      		'text'      => $this->language->get('text_module'),

			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
     		'separator' => ' :: '
  		);

		
  		$data['breadcrumbs'][] = array(
      		'text'      => $this->language->get('heading_title'),

			'href'      => $this->url->link('module/alsobought', 'token=' . $this->session->data['token'], 'SSL'),
     		'separator' => ' :: '
  		);

		$data['action'] = $this->url->link('module/alsobought', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['alsobought'])) {

			foreach ($this->request->post['alsobought'] as $key => $value) {

				$data['data']['alsobought'][$key] = $this->request->post['alsobought'][$key];

			}

		} else {

			$configValue = $this->config->get('alsobought');

			$data['data']['alsobought'] = $configValue;		

		}

		

		
       $data['token']                  = $this->session->data['token'];
       $data['moduleSettings'] = $this->model_module_alsobought->getSetting('alsobought', $store['store_id']);
	   
       $data['data']['alsobought'] = isset($data['moduleSettings']['alsobought']) ? $data['moduleSettings']['alsobought'] : array ();

       $data['stores'] = array_merge(array(0 => array('store_id' => '0', 'name' => $this->config->get('config_name') . ' (' . $data['text_default'].')', 'url' => HTTP_SERVER, 'ssl' => HTTPS_SERVER)), $this->model_setting_store->getStores());
       $data['store']                  = $store;
       
       
       $data['currenttemplate'] =  $this->config->get('config_template');
 

		$this->load->model('design/layout');

		$data['layouts'] = $this->model_design_layout->getLayouts();

		
 if ($this->config->get('alsobought_status')) { 
           $data['alsobought_status'] = $this->config->get('alsobought_status'); 
       } else {
           $data['alsobought_status'] = '0';
       }

       $data['header']                 = $this->load->controller('common/header');
       $data['column_left']            = $this->load->controller('common/column_left');
       $data['footer']                 = $this->load->controller('common/footer');
       
       $this->response->setOutput($this->load->view('module/alsobought.tpl', $data)); 
   }

	
   public function install()
   {
       $this->load->model('module/alsobought');
       $this->model_module_alsobought->install();
   }
   public function uninstall()
   {

		$this->load->model('setting/setting');
       
       $this->load->model('setting/store');
       $this->model_setting_setting->deleteSetting('alsobought_module',0);
       $stores=$this->model_setting_store->getStores();
       foreach ($stores as $store) {
           $this->model_setting_setting->deleteSetting('alsobought_module', $store['store_id']);
       }
       $this->load->model('module/alsobought');
       $this->model_module_alsobought->uninstall();
   }

	

	private function validate() {

		if (!$this->user->hasPermission('modify', 'module/alsobought')) {

			$this->error = true;

		}

		if (!$this->error) {

			return true;

		} else {

			return false;

		}	

	}

	

	private function getCatalogURL() {
       if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
           $storeURL = HTTPS_CATALOG;
       } else {
           $storeURL = HTTP_CATALOG;
       } 
       return $storeURL;
   }

   private function getServerURL() {
       if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
           $storeURL = HTTPS_SERVER;
       } else {
           $storeURL = HTTP_SERVER;
       } 
       return $storeURL;
   }

   private function getCurrentStore($store_id) {    
       if($store_id && $store_id != 0) {
           $store = $this->model_setting_store->getStore($store_id);
       } else {
           $store['store_id'] = 0;
           $store['name'] = $this->config->get('config_name');
           $store['url'] = $this->getCatalogURL(); 
       }
       return $store;
   }

	

}

?>