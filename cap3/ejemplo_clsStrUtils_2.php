<?php
require_once("clsDateUtils.php");

$utils = new dateUtils();

if($_POST['enviar']) {

	//Formateamos la fecha para que nos quede en YYYY-MM-DD
	$fechaFormateada = str_replace('/','',$_POST['fecha']);
	$diaNacimiento = substr($fechaFormateada,0,2);
	$mesNacimiento = substr($fechaFormateada,2,2);
	$anioNacimiento = substr($fechaFormateada,4,4);
	
	$fechaFinal = $anioNacimiento."-".$mesNacimiento."-".$diaNacimiento;

	$utils = new dateUtils();
	
	//Calculamos la edad
	$edad = $utils->calculaEdad($fechaFinal);
	
	//Verificamos que la edad del usuario no sea inferior 18
	if($edad < 18) {
	?>
    	<script>
			alert('Solo se permite el registro a usuarios mayores de 18');
        </script>
    <?
    	exit();
	} else {
		//Continua el registro...
	}

}

?>