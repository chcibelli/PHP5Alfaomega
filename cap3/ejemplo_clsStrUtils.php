<?php
require_once("clsStrUtils.php");

$utils = new strUtils();

$texto = "<div id='container' style='font-family:Arial;border:3px solid red'>En Hoyts lanzaron una <b>promoci&oacute;n</b> para gastar la <u>mitad</u> cada vez que vas al cien. Hasta el 15 de diciembre, quienes compren su entrada por internet <i><a href='home.html'>(nosotros en la home tenemos un link que te lleva a la web de Hoyts)</a></i>, cada entrada vale el <span style='color:blue;font-size:20px;'>50%</span> y sin necesidad de pagar con tarjeta de cr&eacute;dito.</div>";
$texto_limitado = $utils->cortaStrings($texto,260);

echo "<h1>Texto con HTML limitado:</h1>";
echo $texto_limitado;

//Definimos algunos elementos de prueba
$palindromos = array("Neuquén", '07570', 'oso', 'radar','palindromo', 'Zorro',7);

for($i=0;$i<count($palindromos);$i++) {

	if( $utils->esPalindromo($palindromos[$i]) ) {
		echo "<h2>". $palindromos[$i] . " ES PALINDROMO </h2>";
	} else {
		echo "<h2>".$palindromos[$i] . " NO ES PALINDROMO </h2>";
	}

}

$pass = '123456';
$arrAlgoritmos = hash_algos();

echo "Cadena original: <b>" . $pass . "</b><br>";

for($i=0;$i<count($arrAlgoritmos);$i++) {

	echo "Cadena <b>".$arrAlgoritmos[$i]."</b>: " . $utils-> encriptarString($pass,$arrAlgoritmos[$i]) . "<br>";

}

$pass = '123456';

echo "Cadena original: <b>" . $pass . "</b><br>";
echo "Cadena <b> SHA1 </b>: " . $utils->encodeaString($pass,'sha1') . "<br>";

echo "<hr>";

echo "Cadena original: <b>" . $pass . "</b><br>";
echo "Cadena <b> SHA1 </b>: " . $utils->encodeaString($pass,'sha1') . "<br>";

echo "<hr>";

echo "Cadena original: <b>" . $pass . "</b><br>";
echo "Cadena <b> SHA1 </b>: " . $utils->encodeaString($pass,'sha1') . "<br>";


//Simulamos el hash almacenado en la base de datos
$hash = '59a8b70542b74ae46288d6f9a6d162a9691695a7076074';

//Simulamos el ingreso del password por el usuario
$passwordIngresado = '123456';

echo "Hash almacenado en la base de datos: " . $hash . "<br>";

echo "Resultado del analisis del hash: <br><pre>";
$arrHash =  $utils->deHash($hash);
print_r($arrHash);
echo "</pre>";

//Cadena a evaluar SALT+PASSWORD
$evaluar = $arrHash['salt'].$passwordIngresado;

//concatenamos la longitud con el resultado de hashear el str con su salt y luego el salt al final
$resultado =  $arrHash['longitud'].hash('sha1',$evaluar).$arrHash['salt'];

if($resultado == $hash) {
	echo "El password es valido";
} else {
	echo "El password NO es valido";
}


echo "Generamos un string aleatorio <br>";
echo "<b>".$pass = $utils->randomString()."</b>";
echo "<br>";
echo "Generamos un string aleatorio de 12 caracteres <br>";
echo "<b>".$pass = $utils->randomString(12)."</b>";
echo "<br>";
echo "Generamos un string aleatorio de 20 caracteres <br>";
echo "<b>".$pass = $utils->randomString(20)."</b>";


?>