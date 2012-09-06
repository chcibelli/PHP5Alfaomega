<?php
//Verificamos que se haya enviado el formulario
if (isset($_POST['enviar'])) {
    require('clsValidacion.php');
    $validacion = new Validacion();
    //Validamos el formulario campo por campo
    //Verificamos el nombre
    $validacion->validaTexto($_POST['nombre'], false, false, true, 'Por favor ingrese su nombre en forma valida');
    //Verificamos el email admitiendo cualquier dominio
    $validacion->validaEmail($_POST['email'], '', 'Por favor ingrese un email valido');
    //Verificamos la edad ingresada, permitiendo en este caso valores en un intervalo de 18 a 99
    $validacion->validaNumero($_POST['edad'], 18, 99, 'La edad ingresada no es valida');
    //Comprobamos el mensaje ingresado sin superar los 500 caracteres de extensión
    $validacion->validaTexto($_POST['mensaje'], 1, 500, true, 'Por favor ingrese un mensaje');
    //Validamos la fecha ingresada
    $validacion->validaFecha($_POST['fecha'], 'La fecha ingresada no es valida');
    //Validamos el archivo
    $arrExts = array(
        'jpg',
        'gif',
        'png'
    );
    $validacion->validaUpload($_FILES['avatar'], '5000', $arrExts, 'El avatar no es valido');
    //Verificamos si hay errores, en caso afirmativo obtendremos un array, caso contrario devolverá false
    $errores = $validacion->getEstado();
    if (!$errores) {
        echo "No hay errores";
    } else {
        echo "<h1>Listado de errores:</h1>";
        for ($i = 0; $i < count($errores); $i++) {
            echo $errores[$i] . "<br>";
        }
    }
}
?>