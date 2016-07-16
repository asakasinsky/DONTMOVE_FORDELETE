<?php

class ControllerModuleProductquestion extends Controller {
	private $name = 'productquestion';
	protected  $data;
	
	private $settings = Array(
		"productquestion_conf_email" => '',
		"productquestion_conf_maxlen" => 500,
		"productquestion_conf_qpp" => 10,
		"productquestion_module" => ''
	);
	
	private $error = array(); 
	
	public function __construct($registry) {
		parent::__construct($registry);
		$this->registry = $registry;
		$this->data = array_merge(/*$this->data*/array(), $this->load->language('module/productquestion'));
		$this->data['token'] = $this->session->data['token'];
	}
	
	private function editSettings() {
		$this->load->model('module/productquestion');
		$this->load->model('setting/setting');
		if (strcmp(VERSION,'1.5.1.3') == 0) {
			$set = $this->model_module_productquestion->getSettingFixed($this->name);
		} else {
			$set = $this->model_setting_setting->getSetting($this->name);                   
		}

		foreach ($this->settings as $name=>$value) {
			if (!array_key_exists($name,$set)) {
				$set[$name] = $value;
			}
		}

		// sidebar
		if (strcmp(VERSION,'1.5.1') >= 0) {
			if (isset($set["{$this->name}_module"]) && !is_array($set["{$this->name}_module"])) {
				$set["{$this->name}_module"] = unserialize($set["{$this->name}_module"]);
			}
		} else {
			$set["{$this->name}_module"] = '';
			
			foreach ($set as $s => $v) {
				if (strpos($s,'_layout_id') !== false
				||  strpos($s,'_position') !== false
				||  strpos($s,'_sort_order') !== false
				||  strpos($s,'_status') !== false) {
					unset($set[$s]);
				}
			}
			
			$i = 0;
			if (isset($this->request->post["{$this->name}_module"])) {
				$this->request->post["{$this->name}_module"][0];
				foreach($this->request->post["{$this->name}_module"] as $s => $v) {
					$id = $i;
					$set["{$this->name}_" . $id . "_layout_id"] = $v['layout_id'];
					$set["{$this->name}_" . $id . "_position"] = $v['position'];
					$set["{$this->name}_" . $id . "_status"] = $v['status'];
					$set["{$this->name}_" . $id . "_sort_order"] = $v['sort_order'];
					$set["{$this->name}_module"] .= ($id) . ',';
					$i++;
				}
			}
			$set["{$this->name}_module"] = substr($set["{$this->name}_module"],0,-1);
		}
		
		// settings
		foreach($set as $s=>$v) {
			if ($s == "{$this->name}_module") {
				 if (strcmp(VERSION,'1.5.1') < 0) {
				 	continue;
				 } else {
				 	unset($this->request->post[$s][0]);
				 }
			}
			if (isset($this->request->post[$s])) {
				$set[$s] = $this->request->post[$s];
				$this->data[$s] = $this->request->post[$s];
			} elseif ($this->config->get($s)) {
				$this->data[$s] = $this->config->get($s);
			}
		}
		
		$this->model_setting_setting->editSetting($this->name, $set);
	}
		
	private function setBreadcrumbs() {
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link("module/{$this->name}", 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);		
	}
	
	public function install() {
		$this->load->model("module/{$this->name}");
		$this->load->model('setting/setting');
		$this->model_module_productquestion->createTable();
		$this->settings["{$this->name}_conf_email"] = $this->config->get('config_email');
		$this->model_setting_setting->editSetting($this->name, $this->settings);
	}

	public function uninstall() {
		$this->load->model("module/{$this->name}");
		$this->model_module_productquestion->dropTable();
	}
	
	public function editQuestion() {
		$this->load->model("module/{$this->name}");
		$this->model_module_productquestion->editQuestion($this->request->post['pq']);
	}
	 
	public function deleteQuestion() {
		$this->load->model("module/{$this->name}");
		$this->model_module_productquestion->deleteQuestion($this->request->get['question_id']);
	}	
	
	public function saveSettings() {
		$json = array();
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
	        $this->editSettings();
	        $this->session->data['success'] = $this->language->get('success');
		} else {
			$json['errors'][] = $this->language->get('error_permission');
		}
		
		if (strcmp(VERSION,'1.5.1.3') >= 0) {
			$this->response->setOutput(json_encode($json));
		} else {
			$this->load->library('json');
			$this->response->setOutput(Json::encode($json));			
		}			
	}
	
	public function index() {
		$this->load->language("module/{$this->name}");
		$this->load->model("module/{$this->name}");
		$this->load->model('setting/setting');
		
		foreach($this->settings as $s=>$v) {
			$this->data[$s] = $this->config->get($s);
		}

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

        if (isset($this->session->data['success'])) {
                $this->data['success'] = $this->session->data['success'];
                $this->session->data['success'] = '';
        } else {
                $this->data['success'] = '';
        }

		$this->setBreadcrumbs();
				
        $this->data['action'] = $this->url->link("module/{$this->name}", 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		$page = (isset($this->request->get['page'])) ? $this->request->get['page'] : 1;
		$total_questions = $this->model_module_productquestion->getQuestionCount();
		
		$sort = array(
			'order_by' => 'pq.create_time',
			'order_way' => 'DESC',
			'offset' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')			
		);
		
		$this->data['pqQuestions'] = $this->model_module_productquestion->getQuestions(array(), $sort);
		$pagination = new Pagination();
		$pagination->total = $total_questions;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('module/productquestion', 'token=' . $this->session->data['token'] . '&page={page}', 'SSL');
		$this->data['pagination'] = $pagination->render();		
		$this->data['token'] = $this->session->data['token'];
		
		if (strcmp(VERSION,'1.5.1') >= 0) {
			$this->data['modules'] = array();
			if (isset($this->request->post["{$this->name}_module"])) {
				$this->data['modules'] = $this->request->post["{$this->name}_module"];
			} elseif ($this->config->get("{$this->name}_module")) { 
				$this->data['modules'] = $this->config->get("{$this->name}_module");
			}
		} else {
			$this->data['modules'] = array();
			if (isset($this->request->post["{$this->name}_module"])) {
				$this->data['modules'] = $this->request->post["{$this->name}_module"];
			} elseif ($this->config->get("{$this->name}_module") != '' && !is_null($this->config->get("{$this->name}_module"))) {
				$modules = Array();
				$modIds = explode(',', $this->config->get("{$this->name}_module"));
				
				foreach ($modIds as $module) {
					$modules[$module]["layout_id"] = $this->config->get("{$this->name}_{$module}_layout_id");
					$modules[$module]["position"] = $this->config->get("{$this->name}_{$module}_position");
					$modules[$module]["status"] = $this->config->get("{$this->name}_{$module}_status");
					$modules[$module]["sort_order"] = $this->config->get("{$this->name}_{$module}_sort_order");
				}
				$this->data['modules'] = $modules;
			}
		}		
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('design/layout');
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
		
		$this->load->model('localisation/language');
		$this->data['languages'] = $this->model_localisation_language->getLanguages();		
		
		$this->template = "module/{$this->name}.tpl";
		$this->children = array(
			'common/header',
			'common/footer'	
		);

		//v2
		$this->data['header'] 	= $this->load->controller('common/header');
		$this->data['menu'] 	= $this->load->controller('common/menu');
		$this->data['footer'] 	= $this->load->controller('common/footer');
		$this->data['column_left'] 	= $this->load->controller('common/column_left');

		//$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
		$this->response->setOutput($this->load->view($this->template , $this->data), $this->config->get('config_compression'));
	}		
		
	private function validate() {
		if (!$this->user->hasPermission('modify', "module/{$this->name}")) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}

	public function update() {
		$sql = "SHOW CREATE TABLE `" . DB_PREFIX . "productquestion`";
		$result = $this->db->query($sql);
		
		if (strpos($result->row['Create Table'],'customer_language_id') === FALSE) {
			$this->load->model('setting/setting');
			$this->editSettings();
			$this->load->model('localisation/language');
			$languages = $this->model_localisation_language->getLanguages();			
			
			$sql = "RENAME TABLE `" . DB_PREFIX . "productquestion` TO `" . DB_PREFIX . "productquestion_old`";
			$this->db->query($sql);
			echo($sql . "<br><br>");

			echo("CREATING NEW TABLES...<br>");
			$this->load->model("module/{$this->name}");
			$this->model_module_productquestion->createTable();

			$sql = "SELECT * FROM `" . DB_PREFIX . "productquestion_old`";
			$res = $this->db->query($sql);
			echo($sql . "<br><br>");
			
	        foreach ($res->rows as $row)  {
	        	$question_id = (int)($row["id"]);
		    	$customer_id = (int)($row["id_customer"]);
		    	$product_id = (int)($row["id_product"]);
		    	$customer_language_id = (int)$this->model_module_productquestion->getLangIdByCode($this->config->get('config_language'));
		    	$name = $this->db->escape($row["name"]);
		    	$email = $this->db->escape($row["email"]);
		    	$question_text = $this->db->escape($row["question"]);
		    	$answer_text = $this->db->escape($row["answer"]);
		    	$create_time = $row["create_time"];
		    	$answer_time = $row["answer_time"];
		    	$display = $row["display"];
		    	
		        $sql = "INSERT INTO `" . DB_PREFIX . "productquestion`
				            (question_id, product_id, customer_id, customer_language_id, name, email, create_time, answer_time)
		        		VALUES
							($question_id, $product_id, $customer_id, $customer_language_id, '$name', '$email', $create_time, $answer_time)";
							
				$this->db->query($sql);
				echo($sql . "<br><br>");
				
				foreach ($languages as $language) {
			        $sql = "INSERT INTO `" . DB_PREFIX . "productquestion_lang`
					            (question_id, language_id, question_text, answer_text, display)
			        		VALUES
								($question_id, {$language['language_id']}, '$question_text', '$answer_text', $display)";
					echo($sql . "<br><br>");							
					$this->db->query($sql);
				}
				echo("---<br><br>");

	        }			
			echo("DONE!");
			return;
		} else {
			echo "Module is up to date.";
		}
	}		
}
?>
