<?php
define ('FIRST_BG_IMAGE',FPDF_LIBPATH.'f112ek.png');

require(FPDF_LIBPATH.'ufpdf_my.php');

require_once (FPDF_LIBPATH.'nums.class.php');

class PDF_F112ek extends UFPDF_My {

	function PrintFirstPage($title) {
		//Выводим фон-форму
		$this->SetTitle($title);
		$this-> AddFont('TimesNewRomanPS-BoldItalicMT','','timesbi.php');
		$this-> AddFont('Tahoma','','Tahoma.php');
		$this-> AddFont('ArialMT','','arial.php');
		$this-> SetFont('ArialMT','',9);


		$this->AddPage('P');
		$this->Image(FIRST_BG_IMAGE,0,0,210,297);
	}

	function  PrintSenderPhone($phone) {  // выводим телефон магазина
		$this->SetFont('Tahoma','',13);
		if (isset($phone)and(mb_strlen($phone, 'UTF-8')>=1)) {
			$i=0;
			while ($i<=(mb_strlen($phone, 'UTF-8')-1)){
				$this->SetXY(162+$i*3.95,70);
				$this->Cell(0,0,$phone[$i]);
				$i++;
			}
		}
	}
	
	function PrintNumNalozh($val) { // выводим сумму числом
		if ($val == '') return;
		
		$val = floatval($val);
		$rub = floor($val).'';
		$kop = round($val*100 - floor($val)*100);
		$kop = ($kop == 0 ? '00' : $kop.'');

		$this->SetFont('ArialMT','',13);

		$this->SetXY(109,55);
		$this->Cell(17,3.7, $rub ,0,0,'L',0);
		$this->SetXY(130,57);
		$this->Cell(0,0, $kop);
	}

	function PrintSenderName($name) { // выводим иформацию о магазине
		$this->SetFont('Tahoma','',13);
		$name = rtrim ($name);

		/*вывод названия или Ф.И.О.*/
		$this->SetXY(75,75.7);
		$this->MultiCell(0,0,$this->longify($name, 50),0,1,'L');
	}
	
	function PrintSenderAddress($indx,$address) { // выводим иформацию о магазине
		$this->SetFont('Tahoma','',13);

		/*вывод адреса*/
		$address = rtrim($indx .', '. $address);
		$address_parts = $this->splitOnWords($address, array(50, 50));
		$this->SetXY(75,79.3);
		$this->MultiCell(128.5,5.35,$address_parts[0],0,'L');

		$this->SetXY(75,85);
		$this->MultiCell(128.5,5.35,$address_parts[1],0,'L');
	}	
	
	function PrintAddrName($name) {  // выводим имя покупателя
		$this->SetFont('Tahoma','',13);
		/*вывод названия или Ф.И.О.*/
		$this->SetXY(80,108);
		$this->MultiCell(0,0,$this->longify($name, 50),0,1,'L');
	}

	function PrintAddrAddress($address) { // выводим адрес покупателя
		$this->SetFont('Tahoma','',13);
		$address_parts = $this->splitOnWords($address, array(40, 50));
		
		$this->SetXY(95,114);
		$this->MultiCell(0,0,$address_parts[0],0,1,'L');

		$this->SetXY(70,119);
		$this->MultiCell(0,0,$address_parts[1],0,1,'L');
	}

	function  PrintAddrIndex ($indx) {  // выводим индекс покупателя
		$this->SetFont('Tahoma','',14);
		if (isset($indx)and(mb_strlen($indx, 'UTF-8')>=1)) {
			$i=0;
			while ($i<=(mb_strlen($indx, 'UTF-8')-1)){
				$this->SetXY(180.5+$i*3.55,118.5);
				$this->Cell(0,0,$indx[$i]);
				$i++;
			}
		}
	}
	
	// выводим сумму прописью
	function PrintStrNalozh ($val) {
		if ($val == '') return;
		$this->SetFont('Tahoma','',12);
		
		$sum_parts = $this->splitOnWords(num2str($val), array(65, 1));
		$this->SetXY(56, 59);
		$this->Cell(110,5.9,$sum_parts[0],0,0,'C',0);
		$this->SetXY(56, 69);
		$this->Cell(110,5.9,$sum_parts[1],0,0,'C',0);
	}
}
?>
