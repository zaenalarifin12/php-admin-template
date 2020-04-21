<?php
require('qrcode.php');

class QRCodeExtended extends QRCode 
{
	public function saveHtml($width=2) {
		// echo $width % 2; 
		if ($width*1 == 1.5) {
			$height = $width;
		} else {
			$height = is_float($width*1) || $width % 2 > 0 ? $width + 0.5 : $width;
		}
		$width = $width. 'px';
		$height = $height. 'px';
		
		// $height = '1.5px';
        $style = "border-style:none;border-collapse:collapse;margin:0px;padding:0px;";

        $html = "<table style='$style'>";

        for ($r = 0; $r < $this->getModuleCount(); $r++) {

            $html .= "<tr style='$style'>";

            for ($c = 0; $c < $this->getModuleCount(); $c++) {
                $color = $this->isDark($r, $c)? "#000000" : "#ffffff";
                $html .= "<td style='$style;width:$width;height:$height;background-color:$color'></td>";
            }

            $html .= "</tr>";
        }

        $html .= "</table>";
		
		return  $html; 
	}
	
	public function checkError() {
		
		$buffer = new QRBitBuffer();
		$dataArray = $this->qrDataList;
		  
		for ($i = 0; $i < count($dataArray); $i++) {
            /** @var \QRData $data */
            $data = $dataArray[$i];
            $buffer->put($data->getMode(), 4);
            $buffer->put($data->getLength(), $data->getLengthInBits($this->typeNumber) );
            $data->write($buffer);
        }
		 
		
		$rsBlocks = QRRSBlock::getRSBlocks($this->typeNumber, $this->errorCorrectLevel);
		
		$totalDataCount = 0;
        for ($i = 0; $i < count($rsBlocks); $i++) {
            $totalDataCount += $rsBlocks[$i]->getDataCount();
        }

        if ($buffer->getLengthInBits() > $totalDataCount * 8) {
            return ['status' => 'error', 'content' => 'Kombinasi version dan ecc tidak dapat menampung jumlah karakter yang ada, coba naikkan angka version.'];
        }
		return ['status' => 'success'];
	}
}
?>
