<?php 

require("clsAleatorio.php");

$miRandom = new Aleatorio();

for($i=0;$i<10) {
	$miRandom ->generar($i,$i*10);
	echo $miRandom->getNumero($i,$i*10) . "\n";
}

?>