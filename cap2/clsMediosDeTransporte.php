<?php 
class MediosDeTransporte {
	private $nombre;
	private $descripcion;

	public function __construct($nombre,$descripcion) {
		$this->nombre = strtoupper($nombre);
		$this->descripci�n = $descripcion;
	}

	public function verDatos() {
		$arr = array($this->nombre,$this->descripci�n);
		return $arr;
	}
}