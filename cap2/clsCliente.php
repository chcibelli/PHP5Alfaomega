<?php 
class Cliente {
	private $email;
	private $dni;

	function __construct($email,$dni){
		$this->email = $email;
		$this->dni = $dni;
	}

	function __destruct(){
		echo $this->dni . “ destruido”;
	}

	public function verCliente(){
		$datos = array($this->email,$this->dni);
		return $datos;
	}
}