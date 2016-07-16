<?php
class ControllerModuleViewed extends Controller {
	public function index($setting) {
		$this->load->language('module/viewed');

                $url = '';

                if (isset($this->request->get['filter'])) {
                        $url .= '&filter=' . $this->request->get['filter'];
                }

                if (isset($this->request->get['sort'])) {
                        $url .= '&sort=' . $this->request->get['sort'];
                }

                if (isset($this->request->get['order'])) {
                        $url .= '&order=' . $this->request->get['order'];
                }

                if (isset($this->request->get['limit'])) {
                        $url .= '&limit=' . $this->request->get['limit'];
                }

                if (isset($this->request->get['page'])) {
                        $page = $this->request->get['page'];
                } else {
                        $page = 1;
                }

                if (isset($this->request->get['limit'])) {
                        $limit = $this->request->get['limit'];
                } else {
                        $limit = $this->config->get('config_product_limit');
                }
                                
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_tax'] = $this->language->get('text_tax');

		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		$data['products'] = array();

        $products = array();

        if (isset($this->request->cookie['viewed'])) {
            $products = explode(',', $this->request->cookie['viewed']);
        } else if (isset($this->session->data['viewed'])) {
            $products = $this->session->data['viewed'];
        }

        if (isset($this->request->get['route']) && $this->request->get['route'] == 'product/product') {
            $product_id = $this->request->get['product_id'];
            if (is_array($products))$products = array_diff($products, array($product_id));
            else $products = array();
            
            array_unshift($products, $product_id);
            setcookie('viewed', implode(',',$products), time() + 60 * 60 * 24 * 30, '/', $this->request->server['HTTP_HOST']);
            //чтобы не отображать на странице товара
            return;
        }

		if (empty($setting['limit'])) {
			$setting['limit'] = 4;
		}

                $product_total = count($products);
		//$products = array_slice($products, 0, (int)$setting['limit']);
                $images = $this->model_catalog_product->getProductImagesForProducts();
                if ($products)
		foreach ($products as $product_id) {
			$product_info = $this->model_catalog_product->getProduct($product_id);

			if ($product_info) {
				if ($product_info['image']) {
					$image = $this->model_tool_image->resize($product_info['image'], $setting['width'], $setting['height']);
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
				}

				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$price = false;
				}

				if ((float)$product_info['special']) {
					$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$special = false;
				}

				if ($this->config->get('config_tax')) {
					$tax = $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price']);
				} else {
					$tax = false;
				}

				if ($this->config->get('config_review_status')) {
					$rating = $product_info['rating'];
				} else {
					$rating = false;
				}

                                $category = $this->model_catalog_product->getCategories($product_id);//var_dump($category_id);
                                $category = array_pop($category);
                                $category_info = $this->model_catalog_category->getCategory($category["category_id"]);

                                $timestamp = time();
                                $date_time_array = getdate($timestamp);
                                $hours = $date_time_array['hours'];
                                $minutes = $date_time_array['minutes'];
                                $seconds = $date_time_array['seconds'];
                                $month = $date_time_array['mon'];
                                $day = $date_time_array['mday'];
                                $year = $date_time_array['year'];
                                //устанавливается что считать новинками
                                $timestamp = mktime($hours,$minutes,$seconds,$month,$day - $this->config->get('config_days_new_product'),$year);
                                if (($product_info['date_available'] ) > strftime('%Y-%m-%d',$timestamp)) $new_product = true;
                                else $new_product = false;

                                $options = array();

                                foreach ($this->model_catalog_product->getProductOptions($product_id) as $option) {
                                        $product_option_value_data = array();//var_dump($option);

                                        foreach ($option['product_option_value'] as $option_value) {
                                                if (!$option_value['subtract'] || ($option_value['quantity'] > 0)) {
                                                        if ((($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) && (float)$option_value['price']) {
                                                                $price_option = $this->currency->format($this->tax->calculate($option_value['price'], $product_info['tax_class_id'], $this->config->get('config_tax') ? 'P' : false));
                                                        } else {
                                                                $price_option = false;
                                                        }

                                                        $product_option_value_data[] = array(
                                                                'product_option_value_id' => $option_value['product_option_value_id'],
                                                                'option_value_id'         => $option_value['option_value_id'],
                                                                'name'                    => $option_value['name'],
                                                                'image'                   => $this->model_tool_image->resize($option_value['image'], 50, 50),
                                                                'price'                   => $price_option,
                                                                'price_prefix'            => $option_value['price_prefix']
                                                        );
                                                }
                                        }

                                        $options[] = array(
                                                'product_option_id'    => $option['product_option_id'],
                                                'product_option_value' => $product_option_value_data,
                                                'option_id'            => $option['option_id'],
                                                'name'                 => $option['name'],
                                                'type'                 => $option['type'],
                                                'value'                => $option['value'],
                                                'required'             => $option['required']
                                        );
                                }
                                
                                $photos = array();
                                $photos[$product_id][] = $image;
                                if(isset($images[$product_id])){
                                   foreach($images[$product_id] as $image){
                                                $photos[$product_id][] = $this->model_tool_image->resize($image['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
                                        } 
                                }
                                (isset($this->session->data['wishlist']) && in_array($product_id, $this->session->data['wishlist'])) ? $is_liked = true : $is_liked = false;

				$data['products'][] = array(
                                        'is_liked' => $is_liked,
                                        'quantity'    => $product_info['quantity'], 
                                        'category_name' => isset($category_info['name']) ? $category_info['name'] : "",
                                        'new_product' => $new_product,
                                        'options' => $options,
                                        'images'      => $photos,
					'product_id'  => $product_info['product_id'],
					'thumb'       => $image,
					'name'        => $product_info['name'],
					'description' => utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
					'price'       => $price,
					'special'     => $special,
					'tax'         => $tax,
					'rating'      => $rating,
					'href'        => $this->url->link('product/product', 'product_id=' . $product_info['product_id'])
				);
			}
		}

                $pagination = new MyPagination();
                $pagination->total = $product_total;
                $pagination->page = $page;
                $pagination->limit = $limit;
                $pagination->num_links = 3;
                $pagination->url = $this->url->link('product/viewed', $url . '&page={page}');

                $data['pagination'] = $pagination->render();
                                
		if ($data['products']) {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/viewed.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/module/viewed.tpl', $data);
			} else {
				return $this->load->view('default/template/module/viewed.tpl', $data);
			}
		}
	}
}