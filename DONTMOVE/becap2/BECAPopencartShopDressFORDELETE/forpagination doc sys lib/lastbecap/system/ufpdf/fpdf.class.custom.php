<?php
define ('FIRST_BG_IMAGE', FPDF_LIBPATH . 'f7.png');

require(FPDF_LIBPATH . 'ufpdf_my.php');

require_once(FPDF_LIBPATH . 'nums.class.php');

class PDF_Custom extends UFPDF_My {

    private $widths = array(100, 90);
    private $aligns;

    function SetWidths($w) {
        //Set the array of column widths
        $this->widths = $w;
    }

    function SetAligns($a) {
        //Set the array of column alignments
        $this->aligns = $a;
    }

    function wordToLines($text, $max_length_before_wrap = 64) {
        return implode("\r\n", $this->getLinesFromWord($text, $max_length_before_wrap));
    }

    function getLinesFromWord($text, $max_length_before_wrap = 64) {

        $lines = array();

        if (strlen($text) > $max_length_before_wrap) {
            // Split text into words
            $words = explode(" ", $text);
            $total_words = count($words);
            $line = '';
            $word = 0;

            // Generate a new text line from those words until the new line is nearly too long
            while ($word < $total_words and strlen($line . $words[0] . " ") < $max_length_before_wrap) {
                $word++;
                $line .= array_shift($words) . " ";
            }

            $lines[] = $line;
            $other_lines = $this->getLinesFromWord(implode(' ', $words), $max_length_before_wrap);
            foreach($other_lines as $line) {
                $lines[] = $line;
            }
            return $lines;
        } else {
            return array($text);
        }
    }

    function Row($data) {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 5 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            $this->Rect($x, $y, $w, $h);
            //Print the text
            $this->MultiCell($w, 5, $data[$i], 0, $a);
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h) {
        //If the height h would cause an overflow, add a new page immediately
        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w, $txt) {
        //Computes the number of lines a MultiCell of width w will take
        $cw =& $this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }


    function PrintFirstPage($title) {
        $this->SetTitle($title);
        $this-> AddFont('Arial','','arial.php');
        $this-> SetFont('Arial','',15);
        $this->AddPage('P');
//        $this->Image(FIRST_BG_IMAGE, 0, 0, 210, 138);
    }


}

?>
