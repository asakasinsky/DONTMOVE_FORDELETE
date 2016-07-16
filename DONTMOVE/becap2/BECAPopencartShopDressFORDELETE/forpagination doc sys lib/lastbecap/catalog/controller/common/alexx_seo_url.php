<?php
class ControllerCommonAlexxSeoUrl extends Controller {
	public function index() {
		// Add rewrite to url class
		if ($this->config->get('config_seo_url')) {
			$this->url->addRewrite($this);
		}

		// Decode URL
		if (isset($this->request->get['_route_'])) {
			$parts = explode('/', $this->request->get['_route_']);
                        if (($key = array_search("page", $parts)) !== false) {
                            if (isset($parts[$key+1])) $this->request->get['page'] = $parts[$key+1];
                            else $this->request->get['page'] = 1;
                        }
                        if (($key = array_search("search", $parts)) !== false) {
                            if (isset($parts[$key+1])) $this->request->get['search'] = $parts[$key+1];
                        }
                        
			// remove any empty arrays from trailing
			if (utf8_strlen(end($parts)) == 0) {
				array_pop($parts);
			}

			foreach ($parts as $key => $part) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($part) . "'");

                                if ($query->num_rows) {
					$url = explode('=', $query->row['query']);

					if ($url[0] == 'product_id') {
						$this->request->get['product_id'] = $url[1];
					}

					if ($url[0] == 'category_id') {
						if (!isset($this->request->get['path'])) {
							$this->request->get['path'] = $url[1];
						} else {
							$this->request->get['path'] .= '_' . $url[1];
						}
					}

					if ($url[0] == 'manufacturer_id') {
						$this->request->get['manufacturer_id'] = $url[1];
					}

					if ($url[0] == 'information_id') {
						$this->request->get['information_id'] = $url[1];
					}
					
					if ($query->row['query'] && $url[0] != 'information_id' && $url[0] != 'manufacturer_id' && $url[0] != 'category_id' && $url[0] != 'product_id') {
						$this->request->get['route'] = $query->row['query'];
					}
                                } elseif ($part == "page") {
                                    break;
                                }
                                else {
					if (array_search("search", $parts) === false) {
                                            $this->request->get['route'] = 'error/not_found';

                                            break;
                                        }
				}
			}

			if (!isset($this->request->get['route'])) {
				if (isset($this->request->get['product_id'])) {
					$this->request->get['route'] = 'product/product';
				} elseif (isset($this->request->get['path'])) {
					$this->request->get['route'] = 'product/category';
				} elseif (isset($this->request->get['manufacturer_id'])) {
					$this->request->get['route'] = 'product/manufacturer/info';
				} elseif (isset($this->request->get['information_id'])) {
					$this->request->get['route'] = 'information/information';
				}
			}

			if (isset($this->request->get['route'])) {
				return new Action($this->request->get['route']);
			}
		}
	}

	public function rewrite($link) {
		$url_info = parse_url(str_replace('&amp;', '&', $link));

		$url = '';

		$data = array();

		parse_str($url_info['query'], $data);

		foreach ($data as $key => $value) {
			if (isset($data['route'])) {
				if (($data['route'] == 'product/product' && $key == 'product_id') || (($data['route'] == 'product/manufacturer/info' || $data['route'] == 'product/product') && $key == 'manufacturer_id') || ($data['route'] == 'information/information' && $key == 'information_id')) {
					$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = '" . $this->db->escape($key . '=' . (int)$value) . "'");

					if ($query->num_rows && $query->row['keyword']) {
						$url .= '/' . $query->row['keyword'];

						unset($data[$key]);
					}
				} elseif ($key == 'path') {
					$category = explode('_', $value);
					$category = end($category);
					$data['path'] = $this->getPathByCategory($category);

					if (!$data['path']) return $link;

					$categories = explode('_', $data['path']);
					
					foreach ($categories as $category) {
						$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = 'category_id=" . (int)$category . "'");

						if ($query->num_rows && $query->row['keyword']) {
							$url .= '/' . $query->row['keyword'];
						} else {
							$url = '';
							break;
						}
					}

					unset($data[$key]);
//					$categories = explode('_', $value);
//
//					foreach ($categories as $category) {
//						$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = 'category_id=" . (int)$category . "'");
//
//						if ($query->num_rows && $query->row['keyword']) {
//							$url .= '/' . $query->row['keyword'];
//						} else {
//							$url = '';
//
//							break;
//						}
//					}
//
//					unset($data[$key]);
				}
                                else {
                                        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = '" . $this->db->escape($data['route']) . "'");

                                        if ($query->num_rows) {
                                            $url .= '/' . $query->row['keyword'];

                                            unset($data[$key]);
                                        }
                                   }
			}
		}

		if ($url) {
			unset($data['route']);

			$query = '';

			if ($data) {
				foreach ($data as $key => $value) {
					$query .= '&' . rawurlencode((string)$key) . '=' . rawurlencode((string)$value);
				}

				if ($query) {
					$query = '?' . str_replace('&', '&amp;', trim($query, '&'));
				}
			}

			return $url_info['scheme'] . '://' . $url_info['host'] . (isset($url_info['port']) ? ':' . $url_info['port'] : '') . str_replace('/index.php', '', $url_info['path']) . $url . $query;
		} else {
			return $link;
		}
	}

	private function getPathByCategory($category_id) {
				$category_id = (int)$category_id;
				if ($category_id < 1) return false;

				static $path = null;
				if (!is_array($path)) {
					$path = $this->cache->get('category.seopath');
					if (!is_array($path)) $path = array();
				}

				if (!isset($path[$category_id])) {
					$max_level = 10;

					$sql = "SELECT CONCAT_WS('_'";
					for ($i = $max_level-1; $i >= 0; --$i) {
						$sql .= ",t$i.category_id";
					}
					$sql .= ") AS path FROM " . DB_PREFIX . "category t0";
					for ($i = 1; $i < $max_level; ++$i) {
						$sql .= " LEFT JOIN " . DB_PREFIX . "category t$i ON (t$i.category_id = t" . ($i-1) . ".parent_id)";
					}
					$sql .= " WHERE t0.category_id = '" . $category_id . "'";

					$query = $this->db->query($sql);

					$path[$category_id] = $query->num_rows ? $query->row['path'] : false;

					$this->cache->set('category.seopath', $path);
				}

				return $path[$category_id];
			}
}
