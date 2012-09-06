<?php
require("clsMySQLServer.php");
require("clsBusqueda.php");

$porPagina = 2;
$paginar = true;
if(empty($_REQUEST['pagina'])) $_REQUEST['pagina'] = 0;

$buscar = new Busqueda(new MySQLServer('localhost','root','','prueba'));
$buscar->debug=true;
$resultados = $buscar->Buscar('personas',
							'persona_id,persona_nombre,persona_apellido',
							'persona_nombre,persona_apellido',
							'ramiro,federico',
							'LIKE',
							'persona_apellido:asc,persona_nombre:asc',
							$paginar,$_REQUEST['pagina'],$porPagina);


if($resultados) {

	foreach($resultados as $r) {

		echo "<b>".$r['persona_id'] . "</b> " . $r['persona_nombre'] . " " . $r['persona_apellido'] . "<br><hr>";

	}

	if($paginar) {

		echo $buscar->total . " resultados totales<br><br>";

		for($i=1;$i<=ceil($buscar->total/$porPagina);$i++) {
			
			$p=$i-1;
			
			echo "<a href='?pagina=".$p."'>Ir a pagina " . $i . " </a><br> ";
		}

	}
}

?>