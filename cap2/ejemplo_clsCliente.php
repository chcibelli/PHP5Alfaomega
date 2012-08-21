<?php 

require("clsCliente.php");

//Creamos un nuevo objeto y mostramos los datos
$cliente = new Cliente ("Marco",4332234);
echo "<pre>";
print_r($cliente->verCliente());
echo "</pre>";
unset($cliente);

?>