<?php 
class Aleatorio {
	private $valor;

	function __construct(){
		$this->valor = rand();
	}

	private function generar($start=0,$end=null) {
		if($end===null) {
			$end = getrandmax()
		}
		$this->valor = rand($start,$end);
	}
	public function getNumero($min=0,$max=null) {
		$this->generar($min,$max);
		return $this->valor;
	}
}