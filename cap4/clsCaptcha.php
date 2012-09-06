<?php
class Captcha
{

	private static $caracteres = 'abcdefghijklmnopqrstuvwxyz0123456789';

	private function texto($long = 5) {
		for($i=0;$i<$long;$i++) {
			$texto .= self::$caracteres{rand(0,strlen(self::$caracteres))};
		}
	
		return $texto;
	}
	
	public function captcha($w=150,$h=30) {
		
		session_start();
		$_SESSION['captcha'] = self::texto();
		$captcha = imagecreate( $w, $h );
		$colorFondo = imagecolorallocate( $captcha, 0, 0, 255 );
		$colorTexto = imagecolorallocate( $captcha, 255, 255, 0 );
		$colorLinea = imagecolorallocate( $captcha, 255, 105, 180 );
		
		imageline($captcha, 0, 9, 150, 9, $colorLinea);
		imageline($captcha, 0, 15, 150, 15, $colorLinea);
		imageline($captcha, 0, 20, 150, 20, $colorLinea);
		imagestring($captcha, 5, 30, 5, $_SESSION['captcha'], $colorTexto );

		header( "Content-type: image/png" );
		imagepng( $captcha );
		imagedestroy( $captcha );	

	}
	
}