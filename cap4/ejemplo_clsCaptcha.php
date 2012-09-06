<?php
require("clsCaptcha.php");

if(!empty($_POST['enviar'])) {
	session_start();
	if($_SESSION['captcha'] == strtolower($_POST['txt'])) {
		echo "El texto ingresado es correcto";
		exit();
	} else {
		echo "El texto ingresado es incorrecto Por favor intente nuevamente.";
	}

}
?>
<html>
<head>
</head>
<body>
<form action="index.php" method="post">
  <img src="captcha.php" /><br>
  <input name="txt" type="text"><br>
  <input name="enviar" type="submit" value="Verificar Codigo">
</form>
</body>
</html>