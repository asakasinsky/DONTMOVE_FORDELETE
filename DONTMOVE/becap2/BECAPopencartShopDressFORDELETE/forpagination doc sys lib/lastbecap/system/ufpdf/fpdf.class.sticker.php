<?php
define ('FIRST_BG_IMAGE',FPDF_LIBPATH.'f7.png');

require(FPDF_LIBPATH.'ufpdf_my.php');

require_once (FPDF_LIBPATH.'nums.class.php');

class PDF_Blank extends UFPDF_My {

    function PrintFirstPage($title) {
        $this->SetTitle($title);
        $this-> AddFont('Tahoma','','Tahoma.php');
        $this-> SetFont('Tahoma','',12);
        $this->AddPage('P');
        $this->Image(FIRST_BG_IMAGE,0,0,210,138);
    }

	// Индекс отправителя
    function  PrintSenderIndex ($indx) { 
       if (isset($indx)and(mb_strlen($indx, 'UTF-8')>=1)) {
         $i=0;
         while ($i<=(mb_strlen($indx, 'UTF-8')-1)){
          $this->SetFont('Tahoma','',14);
          $this->SetXY(43.7+$i*5.1,62.1);
          $this->Cell(0,0,$indx[$i]);
          $i++;
         }
       }
    }

	// Индекс получателя
    function  PrintAddrIndex ($indx) {
       if (isset($indx)and(mb_strlen($indx, 'UTF-8')>=1)) {
         $i=0;
         while ($i<=(mb_strlen($indx, 'UTF-8')-1)){
          $this->SetFont('Tahoma','',26);
          $this->SetXY(44.9+$i*8.94,111);
          $this->Cell(0,0,$indx[$i]);
          $i++;
         }
       }
    }

	// Кому
    function PrintAddrName ($name) {
		$this->SetFont('Tahoma','',10);
		$name = rtrim ($name);
		
		$name_parts = $this->splitOnWords($name, array(40, 40));
		$this->SetXY(109,69.2);
		/*вывод в 1-ую строку*/
		$this->MultiCell(78.5,5.65,$name_parts[0],0,'L');

		$this->SetXY(101,75);
		/*вывод в 2-ую строку*/
		$this->MultiCell(78.5,5.65,$name_parts[1],0,'L');
     }

	// Куда
    function PrintAddrAddress($address) {
		$this->SetFont('Tahoma','',10);
		$address = rtrim ($address);
		$address_parts = $this->splitOnWords($address, array(38, 40, 40));

		$this->SetXY(109,80.5);
		$this->MultiCell(91,8.2,$address_parts[0],0,'L');
		$this->SetXY(101,85.6);
		$this->MultiCell(91,9.2,$address_parts[1],0,'L');
		$this->SetXY(101,90.7);
		$this->MultiCell(91,9.2,$address_parts[2],0,'L');
    }

	// От кого
    function PrintSenderName ($name) {
		$this->SetFont('Tahoma','',10);
		$name = rtrim ($name);
		
		$name_parts = $this->splitOnWords($name, array(30, 35));
		$this->SetXY(44, 48.4);
		$this->Cell(41,5.4,$name_parts[0],0,2,'L',0,0);
		$this->SetXY(33, 53.3);
		$this->Cell(41,5.4,$name_parts[1],0,2,'L',0,0);
     }

    function PrintSenderAddress($address) {
		$this->SetFont('Tahoma','',10);
		$address = rtrim($address);
		$address_parts = $this->splitOnWords($address, array(38, 40));
		
		$this->SetXY(33,63.9);
		$this->MultiCell(78,8.2,$address_parts[0],0,'L');
		$this->SetXY(33,69.1);
		$this->MultiCell(78,8.2,$address_parts[1],0,'L');
    }

	function PrintStrSum ($val) {
		if ($val == '') return;
		$this->SetFont('Tahoma','',10);
		$sum_parts = $this->splitOnWords(num2str_bk_sticker($val), array(40, 40));
		if (trim($sum_parts[1]) == '') {
			$this->SetXY(97,53.4);
			$this->Cell(80,5.9,$sum_parts[0],0,0,'C',0);
		}
		else {
			$this->SetXY(97,50.4);
			$this->Cell(80,5.9,$sum_parts[0],0,0,'C',0);
			$this->SetXY(97,54.4);
			$this->Cell(80,5.9,$sum_parts[1],0,0,'C',0);
		}
	}
	
	function PrintStrNalozh ($val) {
		if ($val == '') return;
		$this->SetFont('Tahoma','',10);
		$sum_parts = $this->splitOnWords(num2str_bk_sticker($val), array(40, 40));
		if (trim($sum_parts[1]) == '') {
			// Сумма наложенного платежа
			$this->SetXY(97,63.4);
			$this->Cell(80,5.9,$sum_parts[0],0,0,'C',0);
		}
		else {
			// Сумма наложенного платежа
			$this->SetXY(97,60.4);
			$this->Cell(80,5.9,$sum_parts[0],0,0,'C',0);
			$this->SetXY(97,64.4);
			$this->Cell(80,5.9,$sum_parts[1],0,0,'C',0);
		}
	}
}
?>
