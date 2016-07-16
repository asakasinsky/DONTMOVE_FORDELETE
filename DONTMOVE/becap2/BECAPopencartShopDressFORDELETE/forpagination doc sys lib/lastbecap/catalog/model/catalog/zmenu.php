<?php

class ModelCatalogZmenu extends Model {
    private $modules = array();
    private $config_modules = 'zmenu_module';

    private function getLayoutId() {
        $this->load->model('design/layout');
        $this->load->model('catalog/category');
        $this->load->model('catalog/product');
        $this->load->model('catalog/information');

        if (isset($this->request->get['route'])) {
            $route = (string)$this->request->get['route'];
        } else {
            $route = 'common/home';
        }

        $layout_id = 0;

        if ($route == 'product/category' && isset($this->request->get['path'])) {
            $path = explode('_', (string)$this->request->get['path']);

            $layout_id = $this->model_catalog_category->getCategoryLayoutId(end($path));
        }

        if ($route == 'product/product' && isset($this->request->get['product_id'])) {
            $layout_id = $this->model_catalog_product->getProductLayoutId($this->request->get['product_id']);
        }

        if ($route == 'information/information' && isset($this->request->get['information_id'])) {
            $layout_id = $this->model_catalog_information->getInformationLayoutId($this->request->get['information_id']);
        }

        if (!$layout_id) {
            $layout_id = $this->model_design_layout->getLayout($route);
        }

        if (!$layout_id) {
            $layout_id = $this->config->get('config_layout_id');
        }

        return $layout_id;
    }


    public function getMainMenuModule() {
        $this->modules = $this->config->get($this->config_modules);
        $layout_id = $this->getLayoutId();

        if ($this->modules && is_array($this->modules)) {
            foreach ($this->modules as $id => $module) {
                if ($module['position'] == 'zmodule_main_menu' && $module['status'] == 1 && ($layout_id == $module['layout_id'] || $module['layout_id'] == 'zmenu_all_layout')) {
                    return $module;
                }
            }
        }
        return 0;
    }

    public function getModule($module_id) {
        $this->load->model('extension/module');
        $setting = $this->model_extension_module->getModule($module_id);



        if ($setting) {
            $setting['module_id'] = $module_id;
            if($setting['json']) {
                $setting['json'] = html_entity_decode( $setting['json'], ENT_QUOTES, 'UTF-8');
                $setting['json'] = json_decode($setting['json']);
            }
            return $setting;
        } else {
            return array();
        }
    }

}

?>