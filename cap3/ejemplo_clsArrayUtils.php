<?php
$arrProvincias = array(
    "Buenos Aires",
    "Cordoba",
    "Mendoza",
    "San Luis",
    "Rio Negro",
    "Chubut"
);
require_once("clsArrays.php");
$arrUtils = new arrayUtils($arrProvincias);
//Mostramos el contenido inicial del array
echo "<pre>";
print_r($arrUtils->verArray());
echo "</pre>";
//Agregamos algunos elementos
$arrUtils->agregarElemento("La Rioja");
$arrUtils->agregarElemento("Tierra del fuego");
$arrUtils->agregarElemento("Corrientes");
//Eliminamos el elemento en posición 3
$arrUtils->eliminarElemento(3);
//Volvemos a mostrar el contenido del array para verificar lo que agregamos y quitamos
echo "<pre>";
print_r($arrUtils->verArray());
echo "</pre>";
//Indicamos la dirección y ordenamos el array
$arrUtils->setOrden('', 'DESC');
$arrUtils->ordenar();
//Finalmente el array quedó ordenado en forma descendente como se ha indicado
echo "<pre>";
print_r($arrUtils->verArray());
echo "</pre>";
?>