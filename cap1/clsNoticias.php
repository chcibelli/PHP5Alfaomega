<?php 
class Noticias {
	public function verNoticia(){
		$arrArgs = func_get_args();
		
		if(count($arrArgs) == 0) {
			return $this->getNoticiaRandom();
		} else {
			return $this->getNoticiaById($arrArgs[0]);
		}
	}
}