<?php

static $config = NULL;
static $log = NULL;

class ControllerCatalogImport extends Controller { 
	private $error = array();
	private $currentLineNumber = 0;
	private $beginning = 0;

	public function index() {
		$this->load->language('catalog/import');

		$this->document->setTitle($this->language->get('heading_title'));
		 
		$this->load->model('catalog/import');

		$this->getList();
	}

	public function insert() {
		$this->load->language('catalog/import');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/import');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_import->addImport($this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->redirect($this->url->link('catalog/import', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function update() {
		$this->load->language('catalog/import');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/import');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
		
			$this->model_catalog_import->editImport($this->request->get['import_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->redirect($this->url->link('catalog/import', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}
 
	public function delete() {
		$this->load->language('catalog/import');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/import');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $import_id) {
				$this->model_catalog_import->deleteImport($import_id);
			}
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->redirect($this->url->link('catalog/import', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	private function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'i.sort_order';
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/import', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
   		);
		
		$this->data['insert'] = $this->url->link('catalog/import/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('catalog/import/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');	

		$this->data['imports'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
		
		$import_total = $this->model_catalog_import->getTotalImports();
	
		$results = $this->model_catalog_import->getImports($data);
  
		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('catalog/import/update', 'token=' . $this->session->data['token'] . '&import_id=' . $result['import_id'] . $url, 'SSL')
			);
			
			$action[] = array(
				'text' => $this->language->get('text_import'),
				'href' => $this->url->link('catalog/import/importing', 'token=' . $this->session->data['token'] . '&import_id=' . $result['import_id'] . $url, 'SSL')
			);

			$this->data['imports'][] = array(
				'import_id' => $result['import_id'],
				'title'          => $result['title'],
				'sort_order'     => $result['sort_order'],
				'selected'       => isset($this->request->post['selected']) && in_array($result['import_id'], $this->request->post['selected']),
				'action'         => $action
			);
		}	
	
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_title'] = $this->language->get('column_title');
		$this->data['column_sort_order'] = $this->language->get('column_sort_order');
		$this->data['column_action'] = $this->language->get('column_action');
		
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
 
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['sort_title'] = $this->url->link('catalog/import', 'token=' . $this->session->data['token'] . '&sort=id.title' . $url, 'SSL');
		$this->data['sort_sort_order'] = $this->url->link('catalog/import', 'token=' . $this->session->data['token'] . '&sort=i.sort_order' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
		
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $import_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('catalog/import', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'catalog/import_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	private function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['entry_title'] = $this->language->get('entry_title');
		$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['tab_data'] = $this->language->get('tab_data');
		
		$this->data['token'] = $this->session->data['token'];

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['title'])) {
			$this->data['error_title'] = $this->error['title'];
		} else {
			$this->data['error_title'] = array();
		}
		
		$url = '';
			
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),     		
			'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/import', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->load->model("catalog/category");
		$this->data['categories'] = $this->model_catalog_category->getCategories(0);

		$this->load->model('catalog/manufacturer');
		$this->data['manufacturers'] = $this->model_catalog_manufacturer->getManufacturers();

		$this->load->model('catalog/attribute');
		$attributs = $this->model_catalog_attribute->getAttributes();
		
		$this->data["statuses"] = $this->model_catalog_import->getStockStatuses();
		
		$attr_data = array();
		
		foreach( $attributs as $attribut ){
			$attr_data[ $attribut["attribute_group"] ][] = $attribut;
		}

		asort( $attr_data );
		
		$this->data["attributs"] = $attr_data;

		if (!isset($this->request->get['import_id'])) {
			$this->data['action'] = $this->url->link('catalog/import/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/import/update', 'token=' . $this->session->data['token'] . '&import_id=' . $this->request->get['import_id'] . $url, 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('catalog/import', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['import_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$import_info = $this->model_catalog_import->getImport($this->request->get['import_id']);
			
			if( !empty( $import_info["settings"] ) ){
				$import_info["setting"] = unserialize( $import_info["settings"] );
			} else {
				$import_info["setting"] = array();
			}
		}
		
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['import_description'])) {
			$this->data['import_description'] = $this->request->post['import_description'];
		} elseif (isset($this->request->get['import_id'])) {
			$this->data['import_description'] = $this->model_catalog_import->getImportDescriptions($this->request->get['import_id']);
		} else {
			$this->data['import_description'] = array();
		}
		
		if (isset($this->request->post['setting'])) {
			$this->data['setting'] = $this->request->post['setting'];
		} elseif (!empty($import_info['setting'])) {
			$this->data['setting'] = $import_info['setting'];
		} else {
			$this->data['setting'] = array();
		}
		
		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($import_info)) {
			$this->data['sort_order'] = $import_info['sort_order'];
		} else {
			$this->data['sort_order'] = '';
		}

		$this->template = 'catalog/import_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}
	
	private function getFormFile() {
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		
		$this->data['token'] = $this->session->data['token'];
		
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/import', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);
		
		$this->data['action'] = $this->url->link('catalog/import/importing', 'token=' . $this->session->data['token'] . '&import_id=' . $this->request->get['import_id'] . $url, 'SSL');
		$this->data['cancel'] = $this->url->link('catalog/import', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->template = 'catalog/import_form_file.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}
	
	public function importing(){
		$this->load->language('catalog/import');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/import');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
		
			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
		
			if( !empty( $this->request->files["import_file"] ) && !empty( $this->request->get["import_id"] ) ){

				$import_settings = $this->model_catalog_import->getImport( (int) $this->request->get["import_id"] );
			
				if( !empty( $import_settings["settings"] ) ){
					$import_settings["setting"] = unserialize( $import_settings["settings"] );
				} else {
					$import_settings["setting"] = array();
				}

				$filename = $this->request->files["import_file"]["tmp_name"];
				
				if( is_array( $import_settings["setting"] ) )
				$this->importFile( $filename, $import_settings["setting"] );
				
				$this->session->data['success'] = "Импорт закончен. Добавлено продуктов: " . $this->import_product_added . ", обновлено: " . $this->import_product_updated . ", ошибок: " . $this->import_product_error;
				
				$this->redirect($this->url->link('catalog/import', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			
			}
			
			$this->redirect($this->url->link('catalog/import', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			
		}

		$this->getFormFile();
	}
	
	private function importFile( $filename, $import_settings ){
		
		header('Content-Type: text/html; charset=UTF8;');
		
		$formats = array(
			1 => "csv",
			2 => "xls"
		);
		$charsets = array(
			1 => "UTF-8",
			2 => "Windows-1251"
		);
		$delimiter_fields = array(
			1 => ",",
			2 => ";",
			3 => ":",
			4 => "\t",
			5 => " ",
			6 => !empty( $import_settings[1]["delimiter_field_other"] ) ? $import_settings[1]["delimiter_field_other"] : '',
		);
		$delimiter_texts = array(
			1 => '"',
			2 => "'"
		);
		$update_products = array(
			1 => 'name',
			2 => 'sku'
		);

		$this->load->model("catalog/product");
		$this->load->model("localisation/language");
		
		$this->format = !empty( $import_settings[1]["format"] ) && in_array( $import_settings[1]["format"], array_keys($formats) ) ? $formats[ $import_settings[1]["format"] ] : exit("Ошибка формата файла!");
		$this->charset = !empty( $import_settings[1]["charset"] ) && in_array( $import_settings[1]["charset"], array_keys($charsets) ) ? $charsets[ $import_settings[1]["charset"] ] : exit("Ошибка кодировки файла!");
		$this->delimiter_field = !empty( $import_settings[1]["delimiter_field"] ) && in_array( $import_settings[1]["delimiter_field"], array_keys($delimiter_fields) ) ? $delimiter_fields[ $import_settings[1]["delimiter_field"] ] : exit("Ошибка разделителя полей!");
		$this->delimiter_text = !empty( $import_settings[1]["delimiter_text"] ) && in_array( $import_settings[1]["delimiter_text"], array_keys($delimiter_texts) ) ? $delimiter_texts[ $import_settings[1]["delimiter_text"] ] : exit("Ошибка разделителя текста!");
		$this->header_line = !empty( $import_settings[1]["header_line"] ) ? ( (int) $import_settings[1]["header_line"] ): "0";
		$this->start_line = !empty( $import_settings[1]["start_line"] ) ? ( (int) $import_settings[1]["start_line"] ): "1";
		$this->stop_line = !empty( $import_settings[1]["stop_line"] ) ? ( (int) $import_settings[1]["stop_line"] ): "~";

		$this->category_delimiter = !empty( $import_settings[3]["category_delimiter"] ) ? htmlspecialchars_decode( $import_settings[3]["category_delimiter"] ) : ">";

		$this->product_update = !empty( $import_settings[1]["update_product"] ) && in_array( $import_settings[1]["update_product"], array_keys($update_products) ) ? $update_products[ $import_settings[1]["update_product"] ] : exit('Ошибка.');

		// Функция для подготовки читалки файла
		$this->{"preAction" . $this->format . "File"}( $filename );

		if( !$header_info = $this->getHeaderline( $filename ) ) exit("Строка с номером " . $this->header_line . " не обнаружена!");

		if( count( $header_info ) <= 1 ) exit("Количество полей должно быть больше одного. Проверьте файл и настройки импорта");

		$ids = array();

		set_time_limit(0);

		// Get Languages
		$this->languages = $this->model_localisation_language->getLanguages();
		
		// Get Categorys
		$category_ids = array();
		foreach( $this->model_catalog_import->getCategories(0) as $category ){
			$category_ids[ $category["name"] ] = $category["category_id"];
		}
		$this->category_ids = $category_ids;
		
		// Get Manufacturers
		$manufacturer_ids = array();
		foreach( $this->model_catalog_import->getManufacturers() as $manufacturers ){
			$manufacturer_ids[ $manufacturers["name"] ] = $manufacturers["manufacturer_id"];
		}
		$this->manufacturer_ids = $manufacturer_ids;

		$this->import_product_added = 0;
		$this->import_product_updated = 0;
		$this->import_product_error = 0;
		
		$category_array = array();
		$last_type_operation = '';

		while( ( $row_array = $this->getLine() ) !== FALSE ){
			if( count( $row_array ) == count( $header_info ) ) {
				$data = array();
				foreach( $row_array as $key=>$value ){
					$data[ "{" . $header_info[ $key ] . "}" ] = strip_tags( $value );
				}
				// Расположение категорий в файле
				if( !empty( $import_settings[3]["category_column"] ) ) {
					// Категории располагаются на отдельных строках. Продукты находятся под строкой категории.
					// Проверка на строку с названием категории.
					if( !empty( $data[ $import_settings[3]["category_column"] ] ) ) {
						$is_category = true;
						$is_one_line = true;
						foreach( $data as $key => $value ) {
							if( $is_one_line ) { $is_one_line = false; continue; }
							if( !empty( $value )  && $key != $import_settings[3]["category_column"] ) $is_category = false;
						}
						if( $is_category ) {
							// Это категория, обрабатываем её
							
							if( empty( $category_array ) || $import_settings[3]["category_nesting"] == 1) {
								// Это первое нахождение категории, или требуется всего одна категория.
								$category_array = array( 
									0 => $data[ $import_settings[3]["category_column"] ]
								);
							} elseif( $last_type_operation == 'category_added' ) {
								// Последнее действие было добавление категории в список.
								$category_array[] = $data[ $import_settings[3]["category_column"] ];
								if( count ( $category_array ) > $import_settings[3]["category_nesting"] ) {
									unset( $category_array[0] );
									$category_array = array_values( $category_array );
								}
							} elseif( $last_type_operation == 'product_import' ) {
								$category_array[1] = $data[ $import_settings[3]["category_column"] ];
								
							}
							
							$last_type_operation = 'category_added';

							// переход на следущую строку.
							continue;
						}
					}
					
					$data["{generated_category}"] = implode( $this->category_delimiter , $category_array );
					
				}
				
				// Get/Create category from product
				$category_id = $this->import_category( $data, $import_settings[3] );
				
				// Get/Create manufacturer form product
				$manufacturer_id = $this->import_manufacturer( $data, $import_settings[4] );
			
				// Update/Create product & attribut
				$this->import_product( $data, $import_settings[2], $import_settings[5], $manufacturer_id, $category_id );

				$last_type_operation = 'product_import';

			} else {
				// Error line
				$this->import_product_error ++;
			}
			
		}
		
		$this->cache->delete('category');
		$this->cache->delete('product');
		$this->cache->delete('manufacturer');
	}
	
	private function preActionCsvFile( $filename ){
		require_once DIR_ROOT_PATH . 'modules/import[7.07.12]/upload/admin/pear/Spreadsheet/Csv/Csv_reader.php';
		
		$reader = new Csv_reader( $filename, $this->delimiter_field, $this->delimiter_text, $this->charset );
		
		$this->reader = $reader;
		
		$this->filePagesCount = count( $this->reader->sheets );
		
		$this->header_line --;
		$this->start_line --;
		$this->stop_line = is_numeric( $this->stop_line ) ? $this->stop_line - 1 : $this->stop_line;
		
		return true;
	}
	
	private function preActionXlsFile( $filename ){
		// Указываем другой обработчик ошибок. Функция эта находится внизу этого файла ... :)
		set_error_handler('error_handler_for_export',E_ALL);
		
		require_once DIR_ROOT_PATH . 'modules/import[7.07.12]/upload/admin/pear/Spreadsheet/Excel/Reader.php';
		
		$reader=new Spreadsheet_Excel_Reader();
		$reader->setUTFEncoder('iconv');
		$reader->setOutputEncoding('UTF-8');
		$reader->read($filename);
		$this->reader = $reader;
		
		$this->filePagesCount = count( $this->reader->sheets );

		$this->beginning = 1;

	}
	
	private function getLine(){
		// Указатель на следущую строчку
		$this->currentLineNumber ++;
		
		// Перепрыгиваем на строчку начала, если мы выше чем надо
		$this->currentLineNumber = ( $this->currentLineNumber < $this->start_line ) ? $this->start_line : $this->currentLineNumber;
		
		// Последняя строка
		if( $this->reader->sheets[0]["numRows"] <= $this->currentLineNumber ) return false;
		
		// Конечная строка
		if( is_numeric( $this->stop_line ) && $this->stop_line < $this->currentLineNumber ) return false;
		
		$data = array();
		
		for( $i = $this->beginning; $i < $this->reader->sheets[0]["numCols"] + $this->beginning; $i ++ ) {
			$data[$i - $this->beginning] = !empty( $this->reader->sheets[0]["cells"][ $this->currentLineNumber ][$i] ) ? $this->reader->sheets[0]["cells"][ $this->currentLineNumber ][$i] : NULL;
		}
		
		return $data;
	}
	
	private function getHeaderLine(){
		$this->currentLineNumber = $this->header_line;
		
		// Генерируем и возвращаем заголовок, если пользователь указал нулевую строчку.
		if( $this->currentLineNumber == ( $this->beginning - 1 ) ) {
			$header_info = array();
			for( $i = 0; $i < $this->reader->sheets[0]["numCols"]; $i ++ ){
				$header_info[ $i ] = "row_" . ($i + 1);
			}
			return $header_info;
		}

		// Считываем строку с Заголовком
		if( !empty( $this->reader->sheets[0]["cells"][ $this->currentLineNumber ] ) ) {
			$header_info = array();
			for( $i = $this->beginning; $i < $this->reader->sheets[0]["numCols"] + $this->beginning; $i ++ ) {
				$header_info[$i - $this->beginning] = !empty( $this->reader->sheets[0]["cells"][ $this->currentLineNumber ][$i] ) ? $this->reader->sheets[0]["cells"][ $this->currentLineNumber ][$i] : "row_" . ( $i + 1 - $this->beginning ) ;
			}
			return $header_info;
		} else return false;
	}
	
	private function import_product( $rowData, $product_settings, $attribut_settings, $manufacturer_id = 0, $category_id = array() ){

		$_product_description_fields = array();
		$_product_tag_fields = array();
		foreach( $this->languages as $language ){
		
			$product_description_name = !empty( $product_settings["product_description"][ $language["language_id"] ]["name"] ) ? 
					str_replace( array_keys( $rowData ), $rowData, $product_settings["product_description"][ $language["language_id"] ]["name"] ) : "";
		
			$_product_description_fields[ $language["language_id"] ] = array(
				"name" => $product_description_name,
				"meta_description" => !empty( $product_settings["product_description"][ $language["language_id"] ]["meta_description"] ) ? 
					str_replace( array_keys( $rowData ), $rowData, $product_settings["product_description"][ $language["language_id"] ]["meta_description"] ) : "",
				"meta_keyword" => !empty( $product_settings["product_description"][ $language["language_id"] ]["meta_keyword"] ) ? 
					str_replace( array_keys( $rowData ), $rowData, $product_settings["product_description"][ $language["language_id"] ]["meta_keyword"] ) : "",
				"description" => strip_tags( !empty( $product_settings["product_description"][ $language["language_id"] ]["description"] ) ? 
					str_replace( array_keys( $rowData ), $rowData, $product_settings["product_description"][ $language["language_id"] ]["description"] ) : "" )
			);
			$_product_tag_fields[ $language["language_id"] ] = !empty( $product_settings["product_tag"][ $language["language_id"] ] ) ? 
				str_replace( array_keys( $rowData ), $rowData, $product_settings["product_tag"][ $language["language_id"] ] ) : "";
		}

		$_product_attribute = array();

		foreach( $attribut_settings["attributes"] as $attribute_id => $attribute ){
			$_product_attribute_description = array();
		
			$_attr_add = true;
		
			foreach( $this->languages as $language ){
					$_product_attribute_description[ $language["language_id"] ]["text"] = !empty( $attribute[ $language["language_id"] ] ) ?
						str_replace( array_keys( $rowData ), $rowData, $attribute[ $language["language_id"] ] ) : "";
					if( empty( $_product_attribute_description[ $language["language_id"] ]["text"] ) ) $_attr_add = false;
			}
			
			if( $_attr_add )
				$_product_attribute[] = array(
					"name" => "",
					"attribute_id" => $attribute_id,
					"product_attribute_description" => $_product_attribute_description
				);
		}
		
		
		//markup
		$price = !empty( $product_settings["price"] ) ? 
				str_replace( array(
					" ", "'", '"', ","
				), array(
					"", "", "", '.'
				), str_replace( array_keys( $rowData ), $rowData, $product_settings["price"] ) ) : 0;
		
		if( !empty( $product_settings["markup"] ) ){
		
			foreach( $product_settings["markup"] as $markup ){
				if( $price > $markup["ot"] && $price < $markup["do"] ) {
					
					$markup["percent"] = trim( $markup["percent"] );
					if( is_numeric( $markup["percent"] ) ) {
						$price = $price + ( ( $price / 100 ) * $markup["percent"] );
					}
					
					$markup["add"] = trim( $markup["add"] );
					if( is_numeric( $markup["add"] ) ) {
						$price = $price + $markup["add"];
					}
					
					$markup["rounding"] = trim( $markup["rounding"] );
					if( is_numeric( $markup["rounding"] ) ) {
						$price = round( $price, $markup["rounding"] );
					}

					break;
				}
			}
		}
		
		// stock status
		$stock_status_id = !empty( $product_settings["stock_status_id"] ) ? (int) $product_settings["stock_status_id"] : 5;

		$product_info = array(
			"product_description" => $_product_description_fields,
			"product_tag" => $_product_tag_fields,
			"model" => !empty( $product_settings["model"] ) ? 
				str_replace( array_keys( $rowData ), $rowData, $product_settings["model"] ) : "",
			"sku" => !empty( $product_settings["sku"] ) ? 
				str_replace( array_keys( $rowData ), $rowData, $product_settings["sku"] ) : "",
			"upc" => !empty( $product_settings["upc"] ) ? 
				str_replace( array_keys( $rowData ), $rowData, $product_settings["upc"] ) : "",
			"location" => !empty( $product_settings["location"] ) ? 
				str_replace( array_keys( $rowData ), $rowData, $product_settings["location"] ) : "",
			"price" => $price,
			"tax_class_id" => 0,
			"quantity" => (int) !empty( $product_settings["quantity"] ) ? 
				str_replace( array_keys( $rowData ), $rowData, $product_settings["quantity"] ) : "",
			"minimum" => 1,
			"subtract" => 1,
			"stock_status_id" => $stock_status_id,
			"shipping" => 1,
			"keyword" => '',
			"image" => !empty( $product_settings["image"] ) && file_exists( DIR_IMAGE . str_replace( array_keys( $rowData ), $rowData, $product_settings["image"] ) ) ? 
				str_replace( array_keys( $rowData ), $rowData, $product_settings["image"] ) : "",
			"date_available" => date("Y-m-d"),
			"length" => '',
			"width" => '',
			"height" => '',
			"length_class_id" => 1,
			"weight" => '',
			"weight_class_id" => 1,
			"status" => 1,
			"sort_order" => 1,
			"manufacturer_id" => (int) $manufacturer_id,
			"product_category" => $category_id,
			"product_store" => array(
				0 => 0
			),
			"related" => '',
			"product_attribute" => $_product_attribute,
			"option" => '',
			"points" => '',
			"product_reward" =>array(),
			"product_layout" =>array(
				0 => array(
					"layout_id" => ''
				)
			)
		);
		
		if( $this->product_update == "name" ) {
			$product_id = $this->model_catalog_import->getProductByName( $product_description_name );
		} elseif( $this->product_update == "sku" ) {
			$product_id = $this->model_catalog_import->getProductBySku( $product_info["sku"] );
		}
		
		if( $product_id ) {
			// Update Product
			$this->model_catalog_import->editProduct( $product_id, $product_info );
			
			$this->import_product_updated ++;
			
		} else {
			// Add New Product
			$this->model_catalog_import->addProduct( $product_info );
		
			$this->import_product_added ++;
			
		}

	}
	
	private function import_manufacturer( $rowData, $manufacturer_settings ){
	
		$_manufacturer_name = str_replace( array_keys( $rowData ), $rowData, $manufacturer_settings["name"] );
		
		$manufacturer_ids = $this->manufacturer_ids;
		
		if( !empty( $_manufacturer_name ) && empty( $manufacturer_ids[ $_manufacturer_name ] ) ) {
		
			$manufacturer_info = array(
				"name" => $_manufacturer_name,
				"manufacturer_store" => array(
					0 => 0
				),
				"keyword" => '',
				"image" => '',
				"sort_order" => 0
			);
		
			$manufacturer_id = $this->model_catalog_import->addManufacturer( $manufacturer_info );

			$manufacturer_ids[ $_manufacturer_name ] = $manufacturer_id;

			$this->manufacturer_ids = $manufacturer_ids;
		
		} elseif( !empty( $manufacturer_ids[ $_manufacturer_name ] ) ) {
			$manufacturer_id = $manufacturer_ids[ $_manufacturer_name ];
		} else {
			$manufacturer_id = 0;
		};

		return $manufacturer_id;

	}
	
	private function import_category( $rowData, $category_settings ){
		
		$category_ids = $this->category_ids;
		$parent_id = 0;
		
		$category_paths = !empty( $category_settings["category_path"] ) ? explode(",", htmlspecialchars_decode ( $category_settings["category_path"] ) ): array();
		$return = array();
		
		foreach( $category_paths as $key => $category_path ){
		
			$_categorys = !empty( $category_path ) ? explode( $this->category_delimiter , str_replace( array_keys( $rowData ), $rowData, $category_path ) ) : array() ;
			$_categorys_new = array();
			$parent_id = 0;
			
			foreach( $_categorys as $_key => $_category ){
			
				$_category = trim( $_category );
			
				$_category_name = array();
				$_category_meta_description = array();
				$_category_meta_keyword = array();
				$_category_description = array();

				foreach( $this->languages as $language ){
					$_category_name[ $language["language_id"] ] = str_replace( array_keys( $rowData ), $rowData, $_category );
					$_category_meta_description[ $language["language_id"] ] = !empty( $category_settings["category_description"][ $language["language_id"] ]["meta_description"] ) ? str_replace( array_keys( $rowData ), $rowData, $category_settings["category_description"][ $language["language_id"] ]["meta_description"] ) : "";
					$_category_meta_keyword[ $language["language_id"] ] = !empty( $category_settings["category_description"][ $language["language_id"] ]["meta_keyword"] ) ? str_replace( array_keys( $rowData ), $rowData, $category_settings["category_description"][ $language["language_id"] ]["meta_keyword"] ) : "";
					$_category_description[ $language["language_id"] ] = !empty( $category_settings["category_description"][ $language["language_id"] ]["description"] ) ? str_replace( array_keys( $rowData ), $rowData, $category_settings["category_description"][ $language["language_id"] ]["description"] ) : "";
				}

				$_categorys_new[$_key] = trim( str_replace( array_keys( $rowData ), $rowData, $_category ) );
				$new_category_path = implode( " &gt; ", $_categorys_new );

				if( !empty($category_ids[ $new_category_path ]) ){
					$parent_id = $category_ids[$new_category_path];
				} else {
					$_category_description_fields = array();
					foreach( $this->languages as $language ){
						$_category_description_fields[ $language["language_id"] ] = array(
							"name" => $_category_name[ $language["language_id"] ],
							"meta_description" => $_category_meta_description[ $language["language_id"] ],
							"meta_keyword" => $_category_meta_keyword[ $language["language_id"] ],
							"description" => strip_tags( $_category_description[ $language["language_id"] ] ),
						);
					}
					$category_info = array(
						'category_description' => $_category_description_fields,
						'parent_id' => $parent_id,
						'category_store' => array(
							0 => 0
						),
						'keyword' => '',
						'image' => '',
						'column' => 1,
						'sort_order' => 0,
						'status' => '1',
						'category_layout' => array(
							0 => array(
								'layout_id' => ''
							)
						),
					);
					
					$category_ids[$new_category_path] = $this->model_catalog_import->addCategory( $category_info );
					$parent_id = $category_ids[$new_category_path];
					
					
				}
			}
			
			$return[] = $category_ids[$new_category_path];
			
		}

		$this->category_ids = $category_ids;

		return $return;
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/import')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['import_description'] as $language_id => $value) {
			if ((utf8_strlen($value['title']) < 3) || (utf8_strlen($value['title']) > 1024)) {
				$this->error['title'][$language_id] = $this->language->get('error_title');
			}
		}
		
		if( !empty( $this->request->get["import_id"] ) ) {
			if( (int)$this->request->get["import_id"] == 1 && $this->user->getUsername() != 'admin' ){
				$this->error['warning'] = $this->language->get('В демо версии нельзя удалять/изменять настройки первого импорта!');
			}
		}
		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
			
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/import')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if( !empty( $this->request->post["selected"] ) && is_array($this->request->post["selected"]) ) {
			foreach($this->request->post["selected"] as $selected_id){
				if( ( $selected_id == 1 ) && $this->user->getUsername() != 'admin' ){
					$this->error['warning'] = $this->language->get('В демо версии нельзя удалять/изменять настройки первого импорта!');
				}
			}
		}
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}



function error_handler_for_export($errno, $errstr, $errfile, $errline) {
	global $config;
	global $log;
	
	switch ($errno) {
		case E_NOTICE:
		case E_USER_NOTICE:
			$errors = "Notice";
			break;
		case E_WARNING:
		case E_USER_WARNING:
			$errors = "Warning";
			break;
		case E_ERROR:
		case E_USER_ERROR:
			$errors = "Fatal Error";
			break;
		default:
			$errors = "Unknown";
			break;
	}
		
	if (($errors=='Warning') || ($errors=='Unknown')) {
		return true;
	}

	if ($config->get('config_error_display')) {
		echo '<b>' . $errors . '</b>: ' . $errstr . ' in <b>' . $errfile . '</b> on line <b>' . $errline . '</b>';
	}
	
	if ($config->get('config_error_log')) {
		$log->write('PHP ' . $errors . ':  ' . $errstr . ' in ' . $errfile . ' on line ' . $errline);
	}

	return true;
}

?>
