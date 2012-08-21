<?php

function __autoload($className) {
	//Definimos el directorio de nuestras clases y el sufijo
	$file = ‘/classes/cls_’.$class_name.’.php’;

	//Limpiamos la cache para asegurarnos de incluir la última versión de la clase
	clearstatscache();
	//Verificamos si existe el archive y se puede accede a él, y lo incluimos
	if (file_exists($file)) {
		require_once $file;
	}
}
?>