<?php 
require("clsMediosDeTransporte.php");

class Buses extends MediosDeTransporte {
	private $patente;

	public function __construct($nombre,$descripcion,$patente) {
		parent::__construct($nombre,$descripcion);
		$this->patente = $patente;
	}

	public function verBus() {
		$arr = parent::verDatos();
		$arr[] = $this->patente;
		return $arr;
	}
	
}