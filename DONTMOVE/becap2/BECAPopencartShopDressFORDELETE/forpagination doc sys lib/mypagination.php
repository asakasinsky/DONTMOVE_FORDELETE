<?php
class MyPagination {
	public $total = 0;
	public $page = 1;
	public $limit = 20;
	public $num_links = 8;
	public $url = '';
	public $text_first = '|&lt;';
	public $text_last = '&gt;|';
	public $text_next = '&gt;';
	public $text_prev = '&lt;';

	public function fixUrl() {
		$url = $this->url;
		$pos_page = strpos($url, '&page={page}');
		$pos_question = strpos($url, '?');


		if($pos_page > $pos_question) {
			$url = str_replace('&page={page}', '', $url);
			$url = substr_replace($url, '&page={page}', $pos_question, 0);
		}


		
		$this->url = $url;
	}

	public function render() {
		$this->url = str_replace('%7Bpage%7D', '{page}', $this->url);
		$this->url = str_replace('&amp;', '&', $this->url);

		$this->fixUrl();
		$total = $this->total;

		if ($this->page < 1) {
			$page = 1;
		} else {
			$page = $this->page;
		}

		if (!(int)$this->limit) {
			$limit = 10;
		} else {
			$limit = $this->limit;
		}

		$num_links = $this->num_links;
		$num_pages = ceil($total / $limit);


		$output = '<div class="pstrNav">';

		if ($page > 1) {
			$output .= '<a href="' . str_replace('{page}', 1, $this->url) . '">' . $this->text_first . '</a>';
			$output .= '<a href="' . str_replace('{page}', $page - 1, $this->url) . '">' . $this->text_prev . '</a>';
		}

		if ($num_pages > 1) {
			if ($num_pages <= $num_links) {
				$start = 1;
				$end = $num_pages;
			} else {
				$start = $page - floor($num_links / 2);
				$end = $page + floor($num_links / 2);

				if ($start < 1) {
					$end += abs($start) + 1;
					$start = 1;
				}

				if ($end > $num_pages) {
					$start -= ($end - $num_pages);
					$end = $num_pages;
				}
			}

			for ($i = $start; $i <= $end; $i++) {
				if ($page == $i) {
					$output .= '<span>' . $i . '</span>';
				} else/*if ($start == $i || $end == $i || abs($page - $i) <=1)*/ {
					$output .= '<a href="' . str_replace('{page}', $i, $this->url) . '">' . $i . '</a>';
				}
			}
		}

		if ($page < $num_pages) {
			$output .= '<a href="' . str_replace('{page}', $page + 1, $this->url) . '">' . $this->text_next . '</a>';
			$output .= '<a href="' . str_replace('{page}', $num_pages, $this->url) . '">' . $this->text_last . '</a>';
		}

		$output .= '</div>';
                $output = str_replace ('/?page=', '/page/', $output);
                $output = str_replace ('?page=', '/page/', $output);
                $output = str_replace ('&page=', '/page/', $output);
                $output = str_replace ('&amp;page=', '/page/', $output);
                $output = str_replace ('?search=', '/', $output);
                $output = str_replace ('&search=', '/', $output);
                $output = str_replace ('&amp;search=', '/', $output);
                $output = str_replace ('/page/1/', '/', $output);



		if ($num_pages > 1) {
			return $output;
		} else {
			return '';
		}
	}
}