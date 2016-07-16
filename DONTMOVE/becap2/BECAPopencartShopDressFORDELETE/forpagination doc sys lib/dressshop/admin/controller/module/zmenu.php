<?php

/*
 *  zebratratata@gmail.com
 *
 */

class ControllerModuleZmenu extends Controller {
    private $error = array();
    private $furl; // front url
    private $config_name = 'zmenu_data';
    private $setting;
    private $is_oc2;
    private $is_oc2000;


    private function _setOutput($data = array()) {
        $data['header'] = $this->load->controller('common/header');
        $data['footer'] = $this->load->controller('common/footer');
        $data['column_left'] = $this->load->controller('common/column_left');
        $this->response->setOutput($this->load->view($this->template, $data));
    }

    private function _redirect($url) {
        $this->response->redirect($url);
    }

    public function clearCache() {
        $this->cache->delete('zmenu');
        $this->_redirect($this->url->link('module/zmenu', 'token=' . $this->session->data['token'], 'SSL'));
    }


    private function breadCrumbs(&$data) {
        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('module/zmenu', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );
    }


    public function index() {
        $this->load->model('catalog/information');
        $this->load->model('catalog/category');
        $this->load->model('catalog/manufacturer');
        $this->load->model('localisation/language');
        $this->load->model('tool/image');
        $this->load->model('extension/module');


        $data = array();

        $data['no_image'] = $this->model_tool_image->resize('no_image.png', 100, 100);

        $this->furl = new Url("/", "/");

        $item = array(
            'name' => '',
            'id' => 0,
            'json' => '',
            'status' => 1
        );

        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            $this->cache->delete('zmenu');
            if (!isset($this->request->get['module_id'])) {
                $this->model_extension_module->addModule('zmenu', $this->request->post);
            } else {
                $this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
        }


        $module_info = null;
        $module_id = 0;
        if (isset($this->request->get['module_id'])) {
            $module_id = $this->request->get['module_id'];
            $module_info = $this->model_extension_module->getModule($module_id);


            if ($module_info) {
                $item = $module_info;

                $module_info['json'] =  html_entity_decode($module_info['json'], ENT_QUOTES, 'UTF-8');
                $json = json_decode($module_info['json']);

                if (!$json || !is_array($json)) {
                    $json = array();
                }

                foreach ($json as &$o) {
                    if (isset($o->data) && isset($o->data->image)) {
                        if ($o->data->image) {
                            $o->data->thumb = $this->model_tool_image->resize($o->data->image, 100, 100);
                        } else {
                            $o->data->thumb = $data['no_image'];
                        }
                    }

                }

                $item['json'] = json_encode($json);
            }
        }


        $update_item = array(
            'icons' => 0,
            'icons_width' => 16,
            'icons_height' => 16
        );

        foreach ($update_item as $k => $v) {
            if (!isset($item[$k])) {
                $item[$k] = $v;
            }
        }


        $this->language->load('module/zmenu');
        $this->document->setTitle($this->language->get('heading_title2'));

        $this->document->addStyle('view/template/module/zmenu/scripts/form.css?2');

        if ($this->is_oc2 || $this->is_oc2000) {
//            $this->document->addScript('view/template/module/zmenu/scripts/jquery-ui.min.js');
//            $this->document->addStyle('view/template/module/zmenu/scripts/jquery-ui.min.css');
        }
        $this->document->addScript('view/template/module/zmenu/scripts/jquery.mjs.nestedsortable.js?1');
        $this->document->addScript('view/template/module/zmenu/scripts/jquery.tmpl.min.js');
        $this->document->addScript('view/template/module/zmenu/scripts/menu.js?10.05');


        $langs = $this->model_localisation_language->getLanguages();
        $default_lang = $this->config->get('config_language_id');

        $data['languages'] = array();
        foreach ($langs as $k => $l) {
            $l['is_default'] = $l['language_id'] == $default_lang ? 1 : 0;
            $data['languages'][] = $l;
        }


        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');

        $data['text_link'] = $this->language->get('text_link');
        $data['text_custom_link'] = $this->language->get('text_custom_link');
        $data['text_information'] = $this->language->get('text_information');
        $data['text_informations'] = $this->language->get('text_informations');
        $data['text_category'] = $this->language->get('text_category');
        $data['text_categories'] = $this->language->get('text_categories');
        $data['text_product'] = $this->language->get('text_product');
        $data['text_product_help'] = $this->language->get('text_product_help');
        $data['text_show_subcategories'] = $this->language->get('text_show_subcategories');
        $data['text_title'] = $this->language->get('text_title');
        $data['text_link_title'] = $this->language->get('text_link_title');
        $data['text_show_default_title'] = $this->language->get('text_show_default_title');
        $data['text_category_help'] = $this->language->get('text_category_help');
        $data['text_show_all_subcategories'] = $this->language->get('text_show_all_subcategories');
        $data['text_manufacturer'] = $this->language->get('text_manufacturer');
        $data['text_icons'] = $this->language->get('text_icons');
        $data['text_icons_size'] = $this->language->get('text_icons_size');
        $data['text_css_class'] = $this->language->get('text_css_class');
        $data['text_use_default_image'] = $this->language->get('text_use_default_image');


        $data['button_add'] = $this->language->get('button_add');
        $data['button_add_menu'] = $this->language->get('button_add_menu');
        $data['button_save'] = $this->language->get('button_save');
        $data['button_save_and_stay'] = $this->language->get('button_save_and_stay');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['button_add_module'] = $this->language->get('button_add_module');
        $data['button_remove'] = $this->language->get('button_remove');

        $data['entry_name'] = $this->language->get('entry_name');
        $data['entry_status'] = $this->language->get('entry_status');

        $this->language->load('catalog/category');
        $data['text_none'] = $this->language->get('text_none');
        $data['text_default'] = $this->language->get('text_default');
        $data['text_image_manager'] = $this->language->get('text_image_manager');
        $data['text_browse'] = $this->language->get('text_browse');
        $data['text_clear'] = $this->language->get('text_clear');
        $data['text_image'] = $this->language->get('text_image');

        $data['token'] = $this->session->data['token'];
        $data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

        if ($module_id) {
            $data['action'] = $this->url->link('module/zmenu/', 'token=' . $this->session->data['token'].'&module_id='.$module_id, 'SSL');
        } else {
            $data['action'] = $this->url->link('module/zmenu/', 'token=' . $this->session->data['token'], 'SSL');
        }

        $information_data = array(
            'sort' => 'id',
            'order' => 'DESC'
        );

        $categories = $this->model_catalog_category->getCategories(array());
        $informations = $this->model_catalog_information->getInformations($information_data);
        $manufacturers = $this->model_catalog_manufacturer->getManufacturers(array('sort' => 'sort_order'));


        $data['informations'] = array();
        $data['categories'] = array();
        $data['manufacturers'] = array();


        foreach ($informations as $information) {
            $data['informations'][] = array(
                'information_id' => $information['information_id'],
                'title' => $information['title'],
                'href' => $this->furl->link('information/information', 'information_id=' . $information['information_id'], 'SSL'),
                'titles' => $this->model_catalog_information->getInformationDescriptions($information['information_id'])
            );
        }


        foreach ($categories as $category) {
            $cat = $this->model_catalog_category->getCategory($category['category_id']);
            $data['categories'][] = array(
                'category_id' => $category['category_id'],
                'category_path' => $category['name'],
                'name' => isset($cat['name']) ? $cat['name'] : $category['name'],
                'href' => $this->furl->link('product/category', 'path=' . $category['category_id'], 'SSL'),
                'titles' => $this->model_catalog_category->getCategoryDescriptions($category['category_id'])
            );
        }

        foreach ($manufacturers as $manufacturer) {
            $titles = array();

            foreach ($langs as $k => $l) {
                $titles[$l['language_id']] = array(
                    'title' => $manufacturer['name']
                );
            }

            $data['manufacturers'][] = array(
                'manufacturer_id' => $manufacturer['manufacturer_id'],
                'category_path' => $manufacturer['name'],
                'name' => $manufacturer['name'],
                'href' => $this->furl->link('product/manufacturer/info', 'manufacturer_id=' . $manufacturer['manufacturer_id'], 'SSL'),
                'titles' => $titles
            );

        }


        $data['item'] = $item;


        $this->breadCrumbs($data);


        $this->template = 'module/zmenu/form2.tpl';
        $this->data = $data;
        $this->_setOutput($this->data);
    }


}

?>