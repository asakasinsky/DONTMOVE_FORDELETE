<?php
abstract class Model {
	protected $registry;
	
	public function __construct($registry) {
		$this->registry = $registry;
	}
	
	public function __get($key) {
		return $this->registry->get($key);
	}
	
	public function __set($key, $value) {
		$this->registry->set($key, $value);
	}

     /**
     * Преобразование URL
     * @param <type> $string
     * @return <type>
     */
        public function friendlyURL($string) {
        $lit = array(
            "а" => "a",
            "б" => "b",
            "в" => "v",
            "г" => "g",
            "д" => "d",
            "е" => "e",
            "ё" => "yo",
            "ж" => "zh",
            "з" => "z",
            "и" => "i",
            "й" => "y",
            "к" => "k",
            "л" => "l",
            "м" => "m",
            "н" => "n",
            "о" => "o",
            "п" => "p",
            "р" => "r",
            "с" => "s",
            "т" => "t",
            "у" => "u",
            "ф" => "f",
            "х" => "h",
            "ц" => "ts",
            "ч" => "ch",
            "ш" => "sh",
            "щ" => "shch",
            "ъ" => "",
            "ы" => "i",
            "ь" => "",
            "э" => "e",
            "ю" => "yu",
            "я" => "ya",

            "А" => "A",
            "Б" => "B",
            "В" => "V",
            "Г" => "G",
            "Д" => "D",
            "Е" => "E",
            "Ё" => "Yo",
            "Ж" => "Zh",
            "З" => "Z",
            "И" => "I",
            "Й" => "Y",
            "К" => "K",
            "Л" => "L",
            "М" => "M",
            "Н" => "N",
            "О" => "O",
            "П" => "P",
            "Р" => "R",
            "С" => "S",
            "Т" => "T",
            "У" => "U",
            "Ф" => "F",
            "Х" => "H",
            "Ц" => "Ts",
            "Ч" => "Ch",
            "Ш" => "Sh",
            "Щ" => "Shch",
            "Ъ" => "",
            "Ы" => "I",
            "Ь" => "",
            "Э" => "E",
            "Ю" => "Yu",
            "Я" => "Ya",

            "є" => "e",
            "Є" => "E",
            "і" => "i",
            "І" => "I",
            "ї" => "yi",
            "Ї" => "Yi",
    );
        $string = strtr($string, $lit);
        $string = preg_replace("`\[.*\]`U", "", $string);
        $string = preg_replace('`&(amp;)?#?[a-z0-9]+;`i', '-', $string);
        $string = htmlentities($string, ENT_COMPAT, 'utf-8');
        $string = preg_replace("`&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);`i", "\\1", $string);
        $string = preg_replace(array("`[^a-z0-9]`i", "`[-]+`"), "-", $string);

        return strtolower(trim($string, '-'));
    }

    /**
 * генерация уникального URL
 * $keyword - название или введенный пользователем псевдоним
 * $query - значение поля "query" в таблице "url_alias"
 */
    public function generateUniqueUrl($keyword) {
        //преобразовываем $keyword
        $url = $this->friendlyURL($keyword);

        //проверка на существование сгенерированного $url в базе
       $url = $this->getUniqueUrl($url);
        return $url;
    }
/**
 * проверка уникальности значений $url и если оно не уникальное формирование нового $url
 */
    private function getUniqueUrl ($url, $index=''){
        $sql = "SELECT keyword
                    FROM " . DB_PREFIX . "url_alias
                    WHERE keyword='" . $url . $index . "' LIMIT 1";

        $query = $this->db->query($sql);
        //если существует - присваиваем $url новое значение
        if ($query->num_rows)
            $url = $this->getUniqueUrl($url, 1+$index);
        else
           $url = $url . $index;
        return $url;
    }

    public function insertSeoKeyword($name, $query_name, $query_value) {
        if(!$name) {
            return false;
        }
        $this->removeSeoKeyword($query_name, $query_value);

        $seo_url = $this->generateUniqueUrl($name);
        $query_name = $this->db->escape($query_name);
        $query_value = $this->db->escape($query_value);


        if ($seo_url) {
            $seo_url = $this->db->escape($seo_url);
            $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = '$query_name=" . $query_value . "', keyword = '" . $seo_url . "'");
        }
        $this->cache->delete('seo_pro');
    }

    public function removeSeoKeyword($query_name, $query_value) {
        $query_value = $this->db->escape($query_value);
        $query_name = $this->db->escape($query_name);
        $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = '$query_name=" . $query_value . "'");
        $this->cache->delete('seo_pro');
    }
}
?>