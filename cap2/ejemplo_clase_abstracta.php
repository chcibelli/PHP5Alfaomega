<?php
//Creamos la super clase Fruta
class Fruta {
	private $nombre;

	public function comer(){
		echo "Buen provecho!";
	}
}

//Creamos la subclase Manzana que heredara de Fruta
class Manzana extends Fruta {
	public function comer() {
		echo "Que disfrutes tu manzana Newton!";
	}
}

//Ahora utilicemos estas clases para comer una Manzana
$manzana = new Manzana();
$manzana->comer();

//Comamos también una Fruta
$fruta = new Fruta();
$fruta ->comer();
?>