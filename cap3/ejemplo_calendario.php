<html>
<head>
<style>
#calendario td {
	text-align:center;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-weight:normal;
}

#hoy, #dia, #finde {
	width:100px;
	height:100px;
}

#hoy {
	background-color:#3399FF;
	color:white;
}

#dia {
	background-color:#CCCCCC;
}

#finde {
	color:red;
	background-color:#CCCCCC;	
}

#eventos {
	font-size:11px;
	color:#000000;
}
</style>
</head>
<body>
<?
require("clsCalendario.php");		
$cal = new calendario();

$cal->agregarEvento(29,03,2010,'Dentista','Sanatorio Trinidad');
$cal->agregarEvento(16,11,2010,'Reunion','Corrientes 123 piso 2');
$cal->agregarEvento(25,12,2010,'Navidad','Reservar restaurante');
$cal->agregarEvento(16,11,2010,'Almuerzo','Puerto Madero');
$cal->eliminarEvento(16,11,2010,1);

for($i=1;$i<13;$i++) {
	echo $cal->getCalendario(2010,$i);
}

?>

</body>
</html>