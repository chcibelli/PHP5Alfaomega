<?php 

require("clsBuses.php");
$bus = new Buses("Bus BMW", "Ideal para viajes dentro de la provincia, posee TV con DVD","IAP-0232");

$datos = $bus->verBus();

echo $datos[0] . "\n";
echo $datos[1] . "\n";
echo $datos[3] . "\n";

?>