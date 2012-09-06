<?php
class Thumb {

	private static $path = './adjuntos/thumbs/';

	private function thumbExists($img) {
	
		if(file_exists($img)) return true;
		
		return false;
	
	}

	private function isImage($img) {
	
		if( !getimagesize($img) ) {
			return false;
		} else {
			return true;
		}
	
	}

	public function onlineThumb($img,$maxWidth,$maxHeight=0) {
					
		if(!self::isImage($img)) return false;
					
		list($oWidth,$oHeight,$image_type) = getimagesize($img);
		
		switch($image_type){
	        case 1: $im = imagecreatefromgif($img); $ext = '.gif';	break;
	        case 2: $im = imagecreatefromjpeg($img); $ext = '.jpg';	break;
	        case 3: $im = imagecreatefrompng($img); $ext = '.png';	break;
	    }
	       

		$fileDest = self::$path . $maxWidth . "_" . $maxHeight . "_" . md5($img) . $ext;	       
	       
	    if(self::thumbExists($fileDest)) return $fileDest;
	       
	    if($maxHeight == 0) $maxHeight = $oHeight * $maxWidth / $oWidth;
	    
	    $newImg = imagecreatetruecolor($maxWidth, $maxHeight);
	    
	    if(($image_type==1) || ($image_type==3)){
	        imagealphablending($newImg, false);
	        imagesavealpha($newImg,true);
	        $transparent=imagecolorallocatealpha($newImg,255,255,255,127);
	        imagefilledrectangle($newImg,0,0,$maxWidth,$maxHeight,$transparent);
	    }
		 
	    imagecopyresampled($newImg,$im,0,0,0,0,$maxWidth,$maxHeight,$oWidth,$oHeight);

	    switch ($image_type){
	        case 1: imagegif ($newImg,$fileDest,100); break;
	        case 2: imagejpeg($newImg,$fileDest,100); break;
	        case 3: imagepng ($newImg,$fileDest,100); break;
	    }
		imagedestroy($newImg);
		return $fileDest;
	}
		
}