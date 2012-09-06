<?php
class Watermark {

	public function __construct($i,$wm) {
	
		$dim = getimagesize($i);
	
		if($dim) { 
			$img = imagecreatetruecolor($dim[0],$dim[1]);
			$img = imagecreatefromjpeg($i);

			$color = imagecolorallocate($img, 211, 211, 211);

			$fuente = 'fuente.ttf';

			imagettftext($img, 20, 0, $dim[0]/3, $dim[1]/2, $color, $fuente, $wm);

			header("Content-type: image/png");
			imagepng($img);
			imagedestroy($img);
		} else {
			return false;
		}
	}
}