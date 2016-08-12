<?php
session_start();

class CaptchaSecurityImages {

	var $font = '../fonts/monofont.ttf';

	function generateOperator1($characters) {
		$possible = '56789';
		$operator1 = '';
		$i = 0;
		while ($i < $characters) { 
			$operator1 .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
			$i++;
		}
		return $operator1;
	}
        function generateOperator2($characters) {
		$possible = '01234';
		$operator2 = '';
		$i = 0;
		while ($i < $characters) { 
			$operator2 .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
			$i++;
		}
		return $operator2;
	}
        
        function generateOperation() {
		$possible = '+-';
		$operation = '';
		$i = 0;
		while ($i < 1) { 
			$operation .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
			$i++;
		}
		return $operation;
	}

	function CaptchaSecurityImages($width='120',$height='40',$characters='6', $type = false) {
		$operator1 = $this->generateOperator1($characters);
                $operation = $this->generateOperation();
                $operator2 = $this->generateOperator2($characters);
                if($operation == '+'){$imagecode = ($operator1) + ($operator2);}
                if($operation == '-'){$imagecode = ($operator1) - ($operator2);}
                $code = $operator1;
                $code .= $operation;
                $code .= $operator2;
                
		/* font size will be 75% of the image height */
		$font_size = $height * 0.75;
		$image = @imagecreate($width, $height) or die('Cannot initialize new GD image stream');
		/* set the colours */
		$background_color = imagecolorallocate($image, 255, 255, 255);
		$text_color = imagecolorallocate($image, 20, 40, 100);
		$noise_color = imagecolorallocate($image, 100, 120, 180);
		/* generate random dots in background */
		for( $i=0; $i<($width*$height)/3; $i++ ) {
			imagefilledellipse($image, mt_rand(0,$width), mt_rand(0,$height), 1, 1, $noise_color);
		}
		/* generate random lines in background */
		for( $i=0; $i<($width*$height)/150; $i++ ) {
			imageline($image, mt_rand(0,$width), mt_rand(0,$height), mt_rand(0,$width), mt_rand(0,$height), $noise_color);
		}
		/* create textbox and add text */
		$textbox = imagettfbbox($font_size, 0, $this->font, $code) or die('Error in imagettfbbox function');
		$x = ($width - $textbox[4])/2;
		$y = ($height - $textbox[5])/2;
		imagettftext($image, $font_size, 0, $x, $y, $text_color, $this->font , $code) or die('Error in imagettftext function');
		/* output captcha image to browser */
		header('Content-Type: image/jpeg');
		imagejpeg($image);
		imagedestroy($image);
	if($type)
			$_SESSION['security_code_'.$type] = $imagecode;
		else	
			$_SESSION['security_code'] = $imagecode;
	}

}

$width = '120';
$height = '40';
$characters = '1';
$type = !empty($_GET['tp']) ? $_GET['tp'] : 0;
$captcha = new CaptchaSecurityImages($width,$height,$characters,$type);
?>
