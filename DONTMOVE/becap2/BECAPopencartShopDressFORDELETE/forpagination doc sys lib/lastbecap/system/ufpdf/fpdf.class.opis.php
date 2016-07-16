<?php
define ('FIRST_BG_IMAGE',FPDF_LIBPATH.'opis-f107.png');

require(FPDF_LIBPATH.'ufpdf_my.php');

require_once (FPDF_LIBPATH.'nums.class.php');

class PDF_Opis extends UFPDF_My {

	function PrintFirstPage($title) {
		//Выводим фон-форму
		$this->SetTitle($title);
		$this-> AddFont('TimesNewRomanPS-BoldItalicMT','','timesbi.php');
		$this-> AddFont('Tahoma','','Tahoma.php');
		$this-> AddFont('ArialMT','','arial.php');
		$this-> SetFont('ArialMT','',12);


		$this->AddPage('P');
		$this->Image(FIRST_BG_IMAGE,0,0,148,210);
	}

	//Товары в посылке
	function PrintProducts($products) {
            $this->SetFont('ArialMT','',13);
            $i = 0;

            $top = 87;

            foreach ($products as $product) {
                $i++;

                $this->SetXY(10,$top);
                $this->Cell(19,3.7, $i.'' ,0,0,'C',0);

                $this->SetXY(86,$top);
                $this->Cell(19,3.7, $product['quantity'] ,0,0,'C',0);

                $val = floatval($product['total']);
                $rub = floor($val).'';
                $kop = round($val*100 - floor($val)*100);
                $kop = ($kop == 0 ? '00' : $kop.'');
                $str = $rub.' руб. '.$kop.' коп.';
                $this->SetXY(113,$top);
                $this->Cell(19,3.7, $str ,0,0,'C',0);

                $name_parts = $this->splitOnWords(html_entity_decode($product['name'], ENT_QUOTES, 'UTF-8'), array(34, 34, 34, 34));
                foreach ($name_parts as $part) {
                    $part = trim($part);
                    if ($part) {
                        $this->SetXY(24,$top);
                        $this->MultiCell(78.5,3.7,$part,0,'L');
                        $top = $top + 5;
                    }
                }
            }
	}

	//Итоговая сумма и кол-во
	function PrintNumSum ($val, $items) {
		$str = intval($items).' предм., ';
	
		$val = floatval($val);
		$rub = floor($val).'';
		$kop = round($val*100 - floor($val)*100);
		$kop = ($kop == 0 ? '00' : $kop.'');
		
		$str.= $rub.' руб. '.$kop.' коп.';

		$this->SetFont('ArialMT','',13);
		$this->SetXY(76,160);
		/*вывод в 1-ую строку*/
		$this->Cell(19,3.7, $str ,0,0,'C',0);
	}

	//Ф.И.О. получателя
	function PrintAddrName ($name) {  // выводим имя адресата
		$this->SetFont('ArialMT','',12);
		$name = rtrim ($name);
		/*вывод в 1-ую строку*/
		$this->SetXY(29,54);
		$this->Cell(70,3.8,$this->longify($name, 40),0,2,'L',0,0);
	}

	//Адрес и индекс получателя
	function PrintAddrAddress($address, $indx) { // выводим адрес адресата
		$this->SetFont('ArialMT','',13);
		$address = rtrim ($address);
		$address_parts = $this->splitOnWords($indx.', '.$address, array(50, 50));
		$this->SetXY(29,60);
		/*вывод в 1-ю строку*/
		$this->MultiCell(78.5,5.65,$address_parts[0],0,'L');

		/*вывод в 2-ю строку*/
		$this->SetXY(29,67);
		$this->MultiCell(78.5,5.65,$address_parts[1],0,'L');
	}


}
?>