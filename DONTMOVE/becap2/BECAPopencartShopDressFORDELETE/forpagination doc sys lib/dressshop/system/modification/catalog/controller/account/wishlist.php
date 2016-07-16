<?php
class ControllerAccountWishList extends Controller {
	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/wishlist', '', 'SSL');

			
          //$this->response->redirect($this->url->link('account/login', '', 'SSL'));
      
		}

		$this->load->language('account/wishlist');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		if (!isset($this->session->data['wishlist'])) {
			$this->session->data['wishlist'] = array();
		}

		if (isset($this->request->get['remove'])) {
			$key = array_search($this->request->get['remove'], $this->session->data['wishlist']);

			if ($key !== false) {
				unset($this->session->data['wishlist'][$key]);
			}

			$this->session->data['success'] = $this->language->get('text_remove');

			$this->response->redirect($this->url->link('account/wishlist'));
		}

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('account/account', '', 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('account/wishlist')
		);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_empty'] = $this->language->get('text_empty');

		$data['column_image'] = $this->language->get('column_image');
		$data['column_name'] = $this->language->get('column_name');
		$data['column_model'] = $this->language->get('column_model');
		$data['column_stock'] = $this->language->get('column_stock');
		$data['column_price'] = $this->language->get('column_price');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_continue'] = $this->language->get('button_continue');
		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_remove'] = $this->language->get('button_remove');

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}


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
            $product_total = count($this->session->data['wishlist']);

            $pagination = new MyPagination();
            $pagination->total = $product_total;
            $pagination->page = $page;
            $pagination->limit = $limit;
            $pagination->num_links = 3;
            $pagination->url = $this->url->link('account/wishlist', $url . '&page={page}');

            $data['pagination'] = $pagination->render();
          
          $images = $this->model_catalog_product->getProductImagesForProducts();
      
		$data['products'] = array();

		foreach ($this->session->data['wishlist'] as $key => $product_id) {
			$product_info = $this->model_catalog_product->getProduct($product_id);

			if ($product_info) {
				if ($product_info['image']) {
					$image = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
                                        $image_small = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_wishlist_width'), $this->config->get('config_image_wishlist_height'));
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
                                        $image_small = $this->model_tool_image->resize('placeholder.png', $this->config->get('config_image_wishlist_width'), $this->config->get('config_image_wishlist_height'));}

				if ($product_info['quantity'] <= 0) {
					$stock = $product_info['stock_status'];
				} elseif ($this->config->get('config_stock_display')) {
					$stock = $product_info['quantity'];
				} else {
					$stock = $this->language->get('text_instock');
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

				
                        $this->load->model('catalog/category');
                        $category = $this->model_catalog_product->getCategories($product_id);
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
                                $product_option_value_data = array();

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
                        $photos[$product_id][] = array("big" => $image, "small" => $image_small);
                        if(isset($images[$product_id])){
                           foreach($images[$product_id] as $photo){
                                $photos[$product_id][] = array(
                                    "big" => $this->model_tool_image->resize($photo['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height')), 
                                    "small" => $this->model_tool_image->resize($photo['image'], $this->config->get('config_image_wishlist_width'), $this->config->get('config_image_wishlist_height')));
                            } 
                        }

                        $data['products'][] = array(
                            'quantity'    => $product_info['quantity'], 
                            'category_name' => isset($category_info['name']) ? $category_info['name'] : "",
                            'new_product' => $new_product,
                            'options' => $options,
                            'images'      => $photos,
        
					'product_id' => $product_info['product_id'],
					'thumb'      => $image,
					'name'       => $product_info['name'],
					'model'      => $product_info['model'],
					'stock'      => $stock,
					'price'      => $price,
					'special'    => $special,
					'href'       => $this->url->link('product/product', 'product_id=' . $product_info['product_id']),
					'remove'     => $this->url->link('account/wishlist', 'remove=' . $product_info['product_id'])
				);
			} else {
				unset($this->session->data['wishlist'][$key]);
			}
		}

		$data['continue'] = $this->url->link('account/account', '', 'SSL');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/wishlist.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/account/wishlist.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/account/wishlist.tpl', $data));
		}
	}

	public function add() {
		$this->load->language('account/wishlist');

		$json = array();

		if (!isset($this->session->data['wishlist'])) {
			$this->session->data['wishlist'] = array();
		}

		if (isset($this->request->post['product_id'])) {
			$product_id = $this->request->post['product_id'];
		} else {
			$product_id = 0;
		}

		$this->load->model('catalog/product');

		$product_info = $this->model_catalog_product->getProduct($product_id);

		if ($product_info) {
			if (!in_array($this->request->post['product_id'], $this->session->data['wishlist'])) {

          $this->model_catalog_product->updateLiked($this->request->post['product_id']);
      
				$this->session->data['wishlist'][] = (int)$this->request->post['product_id'];

				if ($this->customer->isLogged()) {
					$json['success'] = sprintf($this->language->get('text_success'), $this->url->link('product/product', 'product_id=' . (int)$this->request->post['product_id']), $product_info['name'], $this->url->link('account/wishlist'));
				} else {
					/*ocmod$json['info'] = sprintf($this->language->get('text_login'), $this->url->link('account/login', '', 'SSL'), $this->url->link('account/register', '', 'SSL'), $this->url->link('product/product', 'product_id=' . (int)$this->request->post['product_id']), $product_info['name'], $this->url->link('account/wishlist'));*/
                                        $json['success'] = sprintf($this->language->get('text_success'), $this->url->link('product/product', 'product_id=' . (int)$this->request->post['product_id']), $product_info['name'], $this->url->link('account/wishlist'));
				}
			} else {
				
          $array = $this->session->data['wishlist'];
          if (isset($array))          
          if(FALSE !== $key = array_search($this->request->post['product_id'],$array)) {
            unset($this->session->data['wishlist'][$key]);
             $this->model_catalog_product->updateLiked($this->request->post['product_id'], false);
          }
      
			}

			$json['total'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
		}


                 if(!empty($product_info)) {
                    $product_info = $this->model_catalog_product->getProduct($product_id);
                    $json['total_likes'] =  $product_info['liked'];
                }
           
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function remove() {

	}
}