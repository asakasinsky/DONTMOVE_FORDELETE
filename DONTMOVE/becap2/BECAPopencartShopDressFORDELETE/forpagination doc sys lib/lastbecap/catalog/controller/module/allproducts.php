<?php
//переделано под новинки
class ControllerModuleAllproducts extends Controller {
	public function index($setting) {
		//$data['header'] = $this->load->controller('common/header');
                $this->load->model("catalog/product");
				$this->load->model("catalog/category");
                $data['products'] = array();

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

                $filter_data = array(
                        'sort'               => "id",
                        'order'              => "desc",
                        'start'              => ($page - 1) * $limit,
                        'limit'              => $limit,
                        'days_new_product'       => $this->config->get('config_days_new_product')
                );


                $product_total = $this->model_catalog_product->getTotalProducts($filter_data);

                $results = $this->model_catalog_product->getProducts($filter_data);

                $images = $this->model_catalog_product->getProductImagesForProducts();



                foreach ($results as $result) {
                        if ($result['image']) {
                                $image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
                                $image_small = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_wishlist_width'), $this->config->get('config_image_wishlist_height'));
                        } else {
                                $image = $this->model_tool_image->resize('placeholder.png', $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
                                $image_small = $this->model_tool_image->resize('placeholder.png', $this->config->get('config_image_wishlist_width'), $this->config->get('config_image_wishlist_height'));
                        }

                        $photos = array();
                        $photos[$result['product_id']][] = array("big" => $image, "small" => $image_small);
                        if(isset($images[$result['product_id']])){
                           foreach($images[$result['product_id']] as $photo){
                                $photos[$result['product_id']][] = array(
                                    "big" => $this->model_tool_image->resize($photo['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height')), 
                                    "small" => $this->model_tool_image->resize($photo['image'], $this->config->get('config_image_wishlist_width'), $this->config->get('config_image_wishlist_height')));
                            } 
                        }
                        
                        if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                                $price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
                        } else {
                                $price = false;
                        }

                        if ((float)$result['special']) {
                                $special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
                        } else {
                                $special = false;
                        }

                        if ($this->config->get('config_tax')) {
                                $tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price']);
                        } else {
                                $tax = false;
                        }

                        if ($this->config->get('config_review_status')) {
                                $rating = (int)$result['rating'];
                        } else {
                                $rating = false;
                        }
						
                        $category = $this->model_catalog_product->getCategories($result["product_id"]);//var_dump($category_id);
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
                        if (($result['date_available'] ) > strftime('%Y-%m-%d',$timestamp)) $new_product = true;
                        else $new_product = false;

                        $options = array();

                        foreach ($this->model_catalog_product->getProductOptions($result['product_id']) as $option) {
                                $product_option_value_data = array();//var_dump($option);

                                foreach ($option['product_option_value'] as $option_value) {
                                        if (!$option_value['subtract'] || ($option_value['quantity'] > 0)) {
                                                if ((($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) && (float)$option_value['price']) {
                                                        $price_option = $this->currency->format($this->tax->calculate($option_value['price'], $result['tax_class_id'], $this->config->get('config_tax') ? 'P' : false));
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
                        (isset($this->session->data['wishlist']) && in_array($result['product_id'], $this->session->data['wishlist'])) ? $is_liked = true : $is_liked = false;


                        $data['products'][] = array(
                                'product_id'  => $result['product_id'],
                                                        'is_liked' => $is_liked,
							'quantity'    => $result['quantity'], 
							'category_name' => isset($category_info['name']) ? $category_info['name'] : "",
							'new_product' => $new_product,
							'options' => $options,
                                'thumb'       => $image,
                                'name'        => $result['name'],
                                'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
                                'price'       => $price,
                                'special'     => $special,
							'images'      => $photos,
                                'tax'         => $tax,
                                'rating'      => $result['rating'],
                                'href'        => $this->url->link('product/product', /*'path=' . $this->request->get['path'] . */'product_id=' . $result['product_id'] . $url)
                        );
                }
				$pagination = new MyPagination();
				$pagination->total = $product_total;
				$pagination->page = $page;
				$pagination->limit = $limit;
				$pagination->num_links = 3;
				$pagination->url = $this->url->link('common/home', $url . '&page={page}');

				$data['pagination'] = $pagination->render();

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/product_list.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/product/product_list.tpl', $data);
		} else {
			return $this->load->view('default/template/product/product_list.tpl', $data);
		}
	}
}