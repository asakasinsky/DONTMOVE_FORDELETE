<?php
define ('FIRST_BG_IMAGE',FPDF_LIBPATH.'f113en_1.png');
define ('SECOND_BG_IMAGE',FPDF_LIBPATH.'f113en_2.png');

require(FPDF_LIBPATH.'ufpdf_my.php');

require_once (FPDF_LIBPATH.'nums.class.php');

class PDF_F113 extends UFPDF_My {

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
		$this->SetFont('Tahoma','',10);
		if (isset($indx)and(mb_strlen($indx, 'UTF-8')>=1)) {
			$i=0;
			while ($i<=(mb_strlen($indx, 'UTF-8')-1)){
				$this->SetXY(255+$i*3.03,162.7);
				$this->Cell(0,0,$indx[$i]);
				$i++;
			}
		}
	}

	function  PrintSenderIndex ($indx) { // выводим индекс отправителя
		$this->SetFont('Tahoma','',10);
		if (isset($indx)and(mb_strlen($indx, 'UTF-8')>=1)) {
			$i=0;
			while ($i<=(mb_strlen($indx, 'UTF-8')-1)){
				$this->SetXY(254.6+$i*3.03,89.7);
				$this->Cell(0,0,$indx[$i]);
				$i++;
			}
		}
	}

	function PrintNumNalozh ($val) { // выводим сумму числом
		if ($val == '') return;
		
		$val = floatval($val);
		$rub = floor($val).'';
		$kop = round($val*100 - floor($val)*100);
		$kop = ($kop == 0 ? '00' : $kop.'');

		$this->SetFont('ArialMT','',11);

		$this->SetXY(230,53.3);
		$this->Cell(17,3.7, $rub ,0,0,'C',0);
		$this->SetXY(254,55.1);
		$this->Cell(0,0, $kop);
	}

	//Ф.И.О. получателя
	function PrintAddrName ($name) {  // выводим имя адресата
		$this->SetFont('Tahoma','',10);
		$name_parts = $this->splitOnWords($name, array(30, 60));
		/*вывод названия или Ф.И.О.*/
		$this->SetXY(168,138.7);
		$this->MultiCell(128.5,5.35,$name_parts[0],0,'L');

		$this->SetXY(159,143.9);
		$this->MultiCell(128.5,5.35,$name_parts[1],0,'L');
	}

	//Адрес и индекс получателя
	function PrintAddrAddress($address, $indx) { // выводим адрес адресата
		$this->SetFont('Tahoma','',10);
		$address_parts = $this->splitOnWords($address, array(45, 60, 50));
		/*вывод названия или Ф.И.О.*/
		$this->SetXY(188,148.8);
		$this->MultiCell(128.5,5.35,$address_parts[0],0,'L');

		$this->SetXY(159,154.4);
		$this->MultiCell(128.5,5.35,$address_parts[1],0,'L');

		$this->SetXY(159,160.4);
		$this->MultiCell(128.5,5.35,$address_parts[2],0,'L');
	}

	function PrintSenderNameAddress ($name,$indx,$address){ // выводим иформацию о магазине
		$this->SetFont('Tahoma','',10);
		$name = rtrim ($name);

		$name_parts = $this->splitOnWords($name, array(70, 70));
		/*вывод названия или Ф.И.О.*/
		$this->SetXY(159,63.7);
		$this->MultiCell(128.5,5.35,$name_parts[0],0,'L');

		$this->SetXY(159,68.6);
		$this->MultiCell(128.5,5.35,$name_parts[1],0,'L');

		/*вывод адреса*/
		$address = rtrim($indx .', '. $address);
		$address_parts = $this->splitOnWords($address, array(70, 70));
		$this->SetXY(159,73.6);
		$this->MultiCell(128.5,5.35,$address_parts[0],0,'L');

		$this->SetXY(159,79.2);
		$this->MultiCell(128.5,5.35,$address_parts[1],0,'L');
	}

	function PrintSenderBank ($inn,$name,$kor,$rs,$bik) {
		$this->SetAutoPageBreak(FALSE,1);
		$this->SetFont('Tahoma','',10);

		$this->SetXY(170,98.3);
		$this->MultiCell(129,5.1,$this->longify($name, 60),0,'L');

		if (isset($inn) && (mb_strlen($inn, 'UTF-8')>=1)){
			$i=0;
			while ($i<=(mb_strlen($inn, 'UTF-8')-1)){
				$this->SetXY(161.2+$i*3,96);
				$this->Cell(0,0,$inn[$i]);
				$i++;
			}
		}

		if (isset($kor) && (mb_strlen($kor, 'UTF-8')>=1)){
			$i=0;
			while ($i<=(mb_strlen($kor, 'UTF-8')-1)){
				$this->SetXY(213+$i*3,96);
				$this->Cell(0,0,$kor[$i]);
				$i++;
			}
		}

		if (isset($rs) && (mb_strlen($rs, 'UTF-8')>=1)){
			$i=0;
			while ($i<=(mb_strlen($rs, 'UTF-8')-1)){
				$this->SetXY(169.6+$i*2.99,106);
				$this->Cell(0,0,$rs[$i]);
				$i++;
			}
		}

		if (isset($bik) && (mb_strlen($bik, 'UTF-8')>=1)){
			$i=0;
			while ($i<=(mb_strlen($bik, 'UTF-8')-1)){
				$this->SetXY(245.8+$i*2.99,106);
				$this->Cell(0,0,$bik[$i]);
				$i++;
			}
		}
	}


	// выводим сумму прописью
	function PrintStrNalozh ($val) {
		if ($val == '') return;
		$this->SetFont('Tahoma','',10);
		
		$sum_parts = $this->splitOnWords(num2str($val), array(65, 1));
		$this->SetXY(156, 56.8);
		$this->Cell(110,5.9,$sum_parts[0],0,0,'C',0);
		$this->SetXY(156, 60);
		$this->Cell(110,5.9,$sum_parts[1],0,0,'C',0);
	}

	function PrindDocument($doc, $ser, $nomer, $vydan, $vydanday, $vydanyear) {
/*
		$this->SetFont('Tahoma','',9);
		//вывод в 1-ую строку
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
*/
	}
	
	function PrintAddrName2nd ($name) {  // выводим имя адресата
		$this->SetFont('Tahoma','',10);
		$name = rtrim ($name);
		$name_parts = $this->splitOnWords($name, array(25, 30));

		$this->SetXY(93,38.4);
		$this->Cell(70,3.8,$name_parts[0],0,2,'L',0,0);

		$this->SetXY(87,44.5);
		$this->Cell(100,3.8,$name_parts[1],0,2,'L',0,0);
	}

	function PrintAddrAddress2nd($address, $indx) { // выводим адрес адресата
		$this->SetFont('Tahoma','',12);
		
		$this->SetXY(117,57);
		$this->MultiCell(110,5.8,$indx,0,'L');

		$this->SetFont('Tahoma','',10);
		$address = rtrim ($address);

		$address_parts = $this->splitOnWords($address, array(30, 30, 30, 30, 30, 30));
		$this->SetXY(85,63.5);
		$this->MultiCell(108,5.8,$address_parts[0],0,'L');

		$this->SetXY(85,69.8);
		$this->MultiCell(108,5.8,$address_parts[1],0,'L');
		
		$this->SetXY(85,76);
		$this->MultiCell(108,5.8,$address_parts[2],0,'L');

		$this->SetXY(85,82.8);
		$this->MultiCell(108,5.8,$address_parts[3],0,'L');

		$this->SetXY(85,89);
		$this->MultiCell(108,5.8,$address_parts[4],0,'L');
            }

	function PrintNumNalozh2nd ($val) { // выводим сумму числом
		if ($val == '') return;
		
		$val = floatval($val);
		$rub = floor($val).'';
		$kop = round($val*100 - floor($val)*100);
		$kop = ($kop == 0 ? '00' : $kop.'');

		$this->SetFont('Tahoma','',10);
		$this->SetXY(97,32.7);
		$this->Cell(19,3.7, $rub ,0,0,'C',0);

		$this->SetXY(118,32.7);
		$this->Cell(19,3.7,$kop ,0,0,'C',0);
	}	
}
?>
