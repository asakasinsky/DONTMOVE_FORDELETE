<?php
define ('FIRST_BG_IMAGE',FPDF_LIBPATH.'f116_1n.png');
define ('SECOND_BG_IMAGE',FPDF_LIBPATH.'f116_2n.png');

require(FPDF_LIBPATH.'ufpdf_my.php');

require_once (FPDF_LIBPATH.'nums.class.php');

class PDF_F116 extends UFPDF_My {

	function PrintFirstPage($title) {
		//Выводим фон-форму
		$this->SetTitle($title);
		$this-> AddFont('TimesNewRomanPS-BoldItalicMT','','timesbi.php');
		$this-> AddFont('Tahoma','','Tahoma.php');
		$this-> AddFont('ArialMT','','arial.php');
		$this-> SetFont('ArialMT','',9);


		$this->AddPage('P');
		$this->Image(FIRST_BG_IMAGE,0,0,148,210);
	}

	function PrintSecondPage() {
		$this->AddPage('P');
		$this->Image(SECOND_BG_IMAGE,0,0,148,210);
	}

	function  PrintAddrIndex ($indx) {  // выводим индекс получателя
		$this->SetFont('Tahoma','',10);
		if (isset($indx)and(mb_strlen($indx, 'UTF-8')>=1)) {
			$i=0;
			while ($i<=(mb_strlen($indx, 'UTF-8')-1)){
				$this->SetXY(55+$i*4.82,90);
				$this->Cell(0,0,$indx[$i]);
				$i++;
			}
			$i=0;
			while ($i<=(mb_strlen($indx, 'UTF-8')-1)){
				$this->SetXY(100+$i*4.7,183.8);
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
				$this->SetXY(100+$i*4.7,103);
				$this->Cell(0,0,$indx[$i]);
				$i++;
			}
		}
	}

	function PrintNumSum ($val) { // выводим сумму числом
		if ($val == '') return;
		
		$val = floatval($val);
		$rub = floor($val).'';
		$kop = round($val*100 - floor($val)*100);
		$kop = ($kop == 0 ? '00' : $kop.'');

		$this->SetFont('ArialMT','',11);

		$this->SetXY(42,166);
		$this->Cell(17,3.7, $rub ,0,0,'C',0);
	}

	function PrintNumNalozh ($val) { // выводим сумму числом
		if ($val == '') return;
		
		$val = floatval($val);
		$rub = floor($val).'';
		$kop = round($val*100 - floor($val)*100);
		$kop = ($kop == 0 ? '00' : $kop.'');

		$this->SetFont('ArialMT','',11);

		$this->SetXY(99,166);
		$this->Cell(17,3.7, $rub ,0,0,'C',0);
	}
	
	//Ф.И.О. получателя
	function PrintAddrName ($name) {  // выводим имя адресата
		$this->SetFont('Tahoma','',10);
		/*вывод названия или Ф.И.О.*/
		$this->SetXY(30,74);
		$this->MultiCell(128.5,5.35,$name,0,'L');

		$this->SetXY(32,171.2);
		$this->MultiCell(128.5,5.35,$name,0,'L');
	}

	//Адрес и индекс получателя
	function PrintAddrAddress($address, $indx) { // выводим адрес адресата
		$this->SetFont('Tahoma','',10);
		$address_parts = $this->splitOnWords($address, array(32, 41, 25));
		/*вывод адреса*/
		$this->SetXY(31,79);
		$this->MultiCell(128.5,5.35,$address_parts[0],0,'L');

		$this->SetXY(19,83.3);
		$this->MultiCell(128.5,5.35,$address_parts[1],0,'L');

		$this->SetXY(19,87.8);
		$this->MultiCell(128.5,5.35,$address_parts[2],0,'L');
		
		/*вывод адреса в нижней рамке*/
		$address_parts = $this->splitOnWords($address, array(55, 45));
		$this->SetXY(32,176.5);
		$this->MultiCell(128.5,5.35,$address_parts[0],0,'L');

		$this->SetXY(20,181.7);
		$this->MultiCell(128.5,5.35,$address_parts[1],0,'L');
	}

	function PrintSenderNameAddress ($name,$indx,$address){ // выводим иформацию о магазине
		$this->SetFont('Tahoma','',10);
		$name = rtrim ($name);

		/*вывод названия или Ф.И.О.*/
		$this->SetXY(35,92);
		$this->MultiCell(128.5,5.35,$name,0,'L');

		/*вывод адреса*/
		$address = rtrim($address);
		$address_parts = $this->splitOnWords($address, array(55, 45));
		$this->SetXY(32,96.5);
		$this->MultiCell(128.5,5.35,$address_parts[0],0,'L');

		$this->SetXY(20,101);
		$this->MultiCell(128.5,5.35,$address_parts[1],0,'L');
	}

	// выводим сумму прописью
	function PrintStrSum ($val) {
		if ($val == '') return;
		$this->SetFont('Tahoma','',10);
		
		$sum = num2str_bezkop($val);
		$sum_parts = $this->splitOnWords($sum, array(41, 41));

		if (trim($sum_parts[1]) == '') {
			$this->SetXY(18, 57.5);
			$this->Cell(70,5.9,$sum_parts[0],0,0,'L',0);
		}
		else {
			$this->SetXY(18, 56.5);
			$this->Cell(70,5.9,$sum_parts[0],0,0,'L',0);
			$this->SetXY(18, 59.5);
			$this->Cell(70,5.9,$sum_parts[1],0,0,'L',0);
		}
	}

	// выводим сумму прописью
	function PrintStrNalozh ($val) {
		if ($val == '') return;
		$this->SetFont('Tahoma','',10);
		
		$sum = num2str_bezkop($val);
		$sum_parts = $this->splitOnWords($sum, array(41, 41));

		if (trim($sum_parts[1]) == '') {
			$this->SetXY(18, 66);
			$this->Cell(70,5.9,$sum_parts[0],0,0,'L',0);
		}
		else {
			$this->SetXY(18, 65);
			$this->Cell(70,5.9,$sum_parts[0],0,0,'L',0);
			$this->SetXY(18, 68);
			$this->Cell(70,5.9,$sum_parts[1],0,0,'L',0);
		}
	}
	
	function PrintDocument($doc, $ser, $nomer, $vydan, $vydanday, $vydanyear) {
		$this->SetFont('Tahoma','',10);
		//вывод в 1-ую строку
		$this->SetXY(41,115.5);
		$this->Cell(92,5.1,$doc,0,0,'L',0);
		
		$this->SetXY(71,115.5);
		$this->MultiCell(93,5.1,$ser,0,'L');
		$this->SetXY(86,115.5);
		$this->MultiCell(92,5.1,$nomer,0,'L');
		
		$this->SetXY(108,115.5);
		$this->MultiCell(92,5.1,$this->longify($vydanday,8),0,'L');
		$this->SetXY(121.5,115.5);
		$this->MultiCell(92,5.1,$vydanyear,0,'L');
		
		$this->SetXY(20,120.5);
		$this->MultiCell(92,5.1,$this->longify($vydan,80),0,'L');
	}
}
?>
