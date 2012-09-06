<?php
class SEO {

	private static $limit = 2000;
	private static $especiales = array("á","é","í","ó","ú","ñ","Á","É","Í","Ó","Ú","Ñ","ü"); 
	private static $repEspeciales = array("a","e","i","o","u","n","A","E","I","O","U","N","u");
	
	public function newUrl($str,$basepath='/') {
	
		if(empty($str)) return false;
		
		//Verificamos que la url a devolver no supere el limite de caracteres soportado por los navegadores
		if(strlen($basepath . $str) > self::$limit) substr($str,0,self::limit-$basepath);
		
		//Desencodeamos la URL en caso que venga por Ajax
		$str = rawurldecode($str);
		
		//Reemplazamos caracteres especiales
		$str = str_replace(self::$especiales,self::$repEspeciales,$str);
		
		return $basepath . strtolower(strtr( preg_replace("/[^A-Za-z\d\_\-\ ]/i","",$str) ," ", "-" ));

	}

	public function setUrls($buffer) {
		preg_match_all('/<a.*href="(.+?)".*url-title="(.+?)".*url-basepath="(.+?)"*>(.+?)<\/a>/i', $buffer, $match);
		//Verificamos si tenemos todas las componentes para armar la friendly url
		if (isset($match[1][0]) && isset($match[3][0]) && isset($match[2][0]) ) {
	
			for($i=0;$i<count($match[0]);$i++) {
				$replace[$i][0] = $match[1][$i];
				$replace[$i][1] = $match[3][$i] . self::newUrl($match[2][$i]);
			}

			for($i=0;$i<count($replace);$i++) {
				$buffer = str_replace($replace[$i][0],$replace[$i][1],$buffer);		
			}

		}	
			
		return $buffer;
	}

}