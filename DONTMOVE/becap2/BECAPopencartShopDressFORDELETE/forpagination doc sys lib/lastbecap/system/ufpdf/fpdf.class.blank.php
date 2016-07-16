<?php
define ('FIRST_BG_IMAGE',FPDF_LIBPATH.'postform.png');
define ('SECOND_BG_IMAGE',FPDF_LIBPATH.'postform2.png');

require(FPDF_LIBPATH.'ufpdf_my.php');

require_once (FPDF_LIBPATH.'nums.class.php');

class PDF_Blank extends UFPDF_My {

	function PrintFirstPage($title) {
		//Выводим фон-форму
		$this->SetTitle($title);
		$this-> AddFont('TimesNewRomanPS-BoldItalicMT','','timesbi.php');
		$this-> AddFont('Tahoma','','Tahoma.php');
		$this-> AddFont('ArialMT','','arial.php');
		$this-> SetFont('ArialMT','',9);

		$this->AddPage('L');
		$this->Image(FIRST_BG_IMAGE,0,0,297,210);
	}

	function PrintSecondPage() {
		$this->AddPage('L');
		$this->Image(SECOND_BG_IMAGE,0,0,297,210);
	}

	function  PrintAddrIndex ($indx) {  // выводим индекс получателя
		if (isset($indx)and(mb_strlen($indx, 'UTF-8')>=1)) {
			$i=0;
			while ($i<=(mb_strlen($indx, 'UTF-8')-1)){
				$this->SetFont('TimesNewRomanPS-BoldItalicMT','',15);
				$this->SetXY(30.2+$i*5.1,70.25);
				/*вывод в 1-ую строку*/
				$this->Cell(0,0,$indx[$i]);
				$this->SetXY(30.7+$i*5.1,176);
				/*вывод в 2-ую строку*/
				$this->Cell(0,0,$indx[$i]);

				$i++;
			}
		}
	}

	function  PrintSenderIndex ($indx) { // выводим индекс отправителя
		if (isset($indx)and(mb_strlen($indx, 'UTF-8')>=1)) {
			$i=0;
			while ($i<=(mb_strlen($indx, 'UTF-8')-1)){
				$this->SetFont('TimesNewRomanPS-BoldItalicMT','',15);
				$this->SetXY(30.2+$i*5.1,94.3);
				/*вывод в 1-ую строку*/
				$this->Cell(0,0,$indx[$i]);
				$this->SetXY(172.5+$i*5.1,81.5);
				/*вывод в 2-ую строку*/
				$this->Cell(0,0,$indx[$i]);

				//Извещение о почтовом переводе...
				$this->SetXY(232.5+$i*5.1,164.5);
				$this->Cell(0,0,$indx[$i]);
				$i++;
			}
		}
	}

	function PrintNumSum ($val) { // выводим сумму числом
		if ($val == '') return;
		
		$val = floatval($val);
		$rub = floor($val).'';

		$this->SetFont('ArialMT','',11);
		
		$this->SetXY(38.3,163.5);
		/*вывод в 1-ую строку*/
		$this->Cell(19,3.7, $rub ,0,0,'C',0);
	}

	function PrintNumNalozh ($val) { // выводим сумму числом
		if ($val == '') return;
		
		$val = floatval($val);
		$rub = floor($val).'';
		$kop = round($val*100 - floor($val)*100);
		$kop = ($kop == 0 ? '00' : $kop.'');

		$this->SetFont('ArialMT','',11);
		
		$this->SetXY(94.3,163.2);
		/*вывод в 2-ую строку*/
		$this->Cell(16.6,3.7, $rub ,0,0,'C',0);
		$this->SetXY(122.1,164.5);
		/*вывод в 2-ую строку*/
		$this->Cell(0,0,$kop);
		
		$this->SetXY(235.7,54.2);
		/*вывод в 3-ую строку*/
		$this->Cell(17,3.7, $rub ,0,0,'C',0);
		$this->SetXY(265.1,55.8);
		/*вывод в 3-ую строку*/
		$this->Cell(0,0,$kop);
		
		//ИЗВЕЩЕНИЕ о почтовом переводе наложенного платежа...
		// Справа, ниже линии отреза
		$this->SetXY(234.5,146.7);
		//вывод в 4-ую строку
		$this->Cell(14.8,3.7, $rub,0,0,'C',0);
		$this->SetXY(265.7,148.5);
		//вывод в 4-ую строку
		$this->Cell(0,0,$kop);
	}
	
	//Ф.И.О. получателя
	function PrintAddrName ($name) {  // выводим имя адресата
		$this->SetFont('Tahoma','',9);
		$name = rtrim ($name);
		/*вывод в 1-ую строку*/
		$this->SetXY(30,63.4);
		$this->Cell(70,3.8,$this->longify($name, 30),0,2,'L',0,0);
		/*вывод в 2-ую строку*/
		$this->SetXY(30,168.3);
		$this->Cell(100,3.8,$this->longify($name, 43),0,2,'L',0,0);

		
		// Высылается наложный платеж...
		// Справа, ниже линии отреза
		$name_parts = $this->splitOnWords($name, array(27, 27));
		$this->SetXY(168,162.5);
		$this->MultiCell(57.7,6.8,$name_parts[0],0,'L');
		$this->SetXY(158,170.0);
		$this->Cell(41.7,4.5,$name_parts[1],0,'L');
	}

	//Адрес и индекс получателя
	function PrintAddrAddress($address, $indx) { // выводим адрес адресата
		$this->SetFont('ArialMT','',9);
		$address = rtrim ($address);
		$address_parts = $this->splitOnWords($address, array(32, 65, 66));
		$this->SetXY(60,68);
		/*вывод в 1-ую строку*/
		$this->MultiCell(78.5,5.65,$address_parts[0],0,'L');

		$this->SetXY(20,74);
		$this->MultiCell(78.5,5.65,$address_parts[1],0,'L');

		$this->SetXY(20,80);
		$this->MultiCell(78.5,5.65,$address_parts[2],0,'L');

		
		$address_parts = $this->splitOnWords($address, array(50, 66));
		$this->SetXY(65,173.0);
		$this->MultiCell(108,5.8,$address_parts[0],0,'L');

		$this->SetXY(20,179.5);
		$this->MultiCell(108,5.8,$address_parts[1],0,'L');
		
		// "Высылается наложный платеж
		$address_parts = $this->splitOnWords(($indx ? $indx.', ' : '').$address, array(25, 40, 40));
		$this->SetXY(173,146);
		$this->MultiCell(54,7.3,$address_parts[0],0,'L');

		$this->SetXY(158,151.5);
		$this->MultiCell(54,7.3,$address_parts[1],0,'L');

		$this->SetXY(158,157);
		$this->MultiCell(54,7.3,$address_parts[2],0,'L');
	}

	function PrintAddrName2nd ($name) {  // выводим имя адресата
		$this->SetFont('Tahoma','',9);
		$name = rtrim ($name);
		$name_parts = $this->splitOnWords($name, array(25, 30));

		$this->SetXY(96,134.8);
		$this->Cell(70,3.8,$name_parts[0],0,2,'L',0,0);

		$this->SetXY(89,140.8);
		$this->Cell(100,3.8,$name_parts[1],0,2,'L',0,0);
	}

	function PrintAddrAddress2nd($address, $indx) { // выводим адрес адресата
		$this->SetFont('ArialMT','',11);
		$address = rtrim ($address);

		$this->SetXY(115,145.4);
		$this->MultiCell(108,5.8,$indx,0,'L');

		$this->SetFont('ArialMT','',9);
		$address_parts = $this->splitOnWords($address, array(30, 30, 30, 30));
		$this->SetXY(89,156.5);
		$this->MultiCell(108,5.8,$address_parts[0],0,'L');

		$this->SetXY(89,162.1);
		$this->MultiCell(108,5.8,$address_parts[1],0,'L');
		
		$this->SetXY(89,167.7);
		$this->MultiCell(108,5.8,$address_parts[2],0,'L');

		$this->SetXY(89,173.3);
		$this->MultiCell(108,5.8,$address_parts[3],0,'L');
	}

	function PrintNumNalozh2nd ($val) { // выводим сумму числом
		if ($val == '') return;
		
		$val = floatval($val);
		$rub = floor($val).'';
		$kop = round($val*100 - floor($val)*100);
		$kop = ($kop == 0 ? '00' : $kop.'');

		$this->SetFont('ArialMT','',11);
		$this->SetXY(102,129.5);
		$this->Cell(19,3.7, $rub ,0,0,'C',0);

		$this->SetXY(118,129.5);
		$this->Cell(19,3.7,$kop ,0,0,'C',0);
	}

	function PrintSenderNameAddress ($name,$indx,$address){ // выводим иформацию о магазине
		$this->SetFont('ArialMT','',9);
		$this->SetXY(32,87.0);
		$name = rtrim ($name);
		/*вывод в 1-ую строку*/
		$this->Cell(102,3.8,$this->longify($name, 55),0,2,'L',0,0);

		$address_parts = $this->splitOnWords($address, array(50, 95));
		/*вывод 1-го адреса*/
		$this->SetXY(60,92.1);
		$address = rtrim ($address);
		$this->MultiCell(108.5,5.15, $address_parts[0],0,'L');

		$this->SetXY(20,98.2);
		$this->MultiCell(108.5,5.15,$address_parts[1],0,'L');

		$name_parts = $this->splitOnWords($name/*.'  '.$indx.', '.$address*/, array(75, 75));
		/*вывод 2-х названия и адреса*/
		$this->SetXY(172.5,66.5);
		$address = rtrim ($address);
		$this->MultiCell(128.5,5.35,$name_parts[0],0,'L');

		$this->SetXY(162.5,72.5);
		$this->MultiCell(128.5,5.35,$name_parts[1],0,'L');
		
		//Извещение о почтовом перевода
		$address_parts = $this->splitOnWords($address, array(35, 35, 35));
		/*
		$this->SetXY(262,162.5);
		$this->MultiCell(138.5,5.35,$address_parts[0],0,'L');
		*/
		$this->SetXY(225,168);
		$this->MultiCell(138.5,5.35,$address_parts[0],0,'L');
		$this->SetXY(225,173.5);
		$this->MultiCell(138.5,5.35,$address_parts[1],0,'L');
		$this->SetXY(225,179);
		$this->MultiCell(138.5,5.35,$address_parts[2],0,'L');
		
		$name_parts = $this->splitOnWords($name, array(30, 30));
		$this->SetXY(230,151.5);
		$this->MultiCell(138.5,5.35,$name_parts[0],0,'L');
		$this->SetXY(230,157);
		$this->MultiCell(138.5,5.35,$name_parts[1],0,'L');

	}

	function PrintSenderBank ($rs,$name,$town,$bank_addr,$kor,$bik,$inn){
		$this->SetAutoPageBreak(FALSE,1);
		$this->SetFont('ArialMT','',9);
		// вывод 1-го адреса
		if ($kor<>''){
			$res1 = $name.', '.$town.', '.$bank_addr;
		}
		else {
			$res1 = $name;
		}
		$address_parts = $this->splitOnWords($res1, array(56, 83));

		$this->SetXY(202.7,79.0);
		$this->MultiCell(129,5.1,$address_parts[0],0,'L');

		$this->SetXY(162.5,85.5);
		$this->MultiCell(129,5.1,$address_parts[1],0,'L');

		$attr_parts = $this->splitOnWords($kor.' '.$bik." ".$inn, array(56, 56));
		$this->SetXY(162.5,91.8);
		$this->MultiCell(92,5.1,$attr_parts[0],0,'L');
		$this->SetXY(162.5,96.8);
		$this->MultiCell(92,5.1,$attr_parts[1],0,'L');
	}


	// выводим сумму прописью
	function PrintStrSum ($val) {
		if ($val == '') return;
		$this->SetFont('Tahoma','',10);
		$this->SetXY(25,50.0);
		
		/*вывод в 1-ую строку*/
		$this->Cell(80,5.9,num2str_bezkop($val),0,0,'C',0);
	}
	
	// выводим сумму прописью
	function PrintStrNalozh ($val) {
		if ($val == '') return;
		$this->SetFont('Tahoma','',10);
		
		$this->SetXY(25,56.0);
		/*вывод в 2-ую строку*/
		$this->Cell(80,5.9,num2str_bezkop($val),0,0,'C',0);
		
		$this->SetXY(170.5,59);
		/*вывод в 3-ую строку*/
		$this->Cell(110,5.9,num2str($val),0,0,'C',0);
	}
	

	function PrindDocument($doc, $ser, $nomer, $vydan, $vydanday, $vydanyear) {
		$this->SetFont('Tahoma','',9);
		/*вывод в 1-ую строку*/
		$this->SetXY(40,114.8);
		$this->Cell(92,5.1,$doc,0,0,'L',0);
		
		$this->SetXY(70,114.8);
		$this->MultiCell(93,5.1,$ser,0,'L');
		$this->SetXY(86,114.8);
		$this->MultiCell(92,5.1,$nomer,0,'L');
		
		$this->SetXY(110,114.5);
		$this->MultiCell(92,5.1,$this->longify($vydanday,11),0,'L');
		$this->SetXY(130,114.4);
		$this->MultiCell(92,5.1,$vydanyear,0,'L');
		
		$this->SetXY(20,121.5);
		$this->MultiCell(92,5.1,$this->longify($vydan,80),0,'L');
	}
}
?>
