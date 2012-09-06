<?php
class Firmas {

	public function __construct($bgFile) {
	
		$dim = getimagesize($bgFile);
	
		if($dim) { 
			$firma = imagecreatetruecolor($dim[0],$dim[1]);
			$firma = imagecreatefromjpeg($bgFile);

			$color = imagecolorallocate($firma, 255, 255, 255);
			$fuente = 'fuente.ttf';

			imagettftext($firma, 14, 0, 10, 35, $color, $fuente, "Christian Cibelli");
			imagettftext($firma, 11	, 0, 10, 55, $color, $fuente, "chcibelli@gmail.com");
			imagettftext($firma, 11, 0, 10, 75, $color, $fuente, "http://www.christiancibelli.com");

			header("Content-type: image/png");
			imagepng($firma);
			imagedestroy($firma);
		} else {
			return false;
		}
	}
}