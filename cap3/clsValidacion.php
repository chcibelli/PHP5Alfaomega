<?php
class Validacion
{
    //Definimos un array privado donde almacenar los errores cuando no se cumpla la condici�n
    private $error;
    // Validaci�n de texto con espacios o sin ellos
    // Posibilidad de enviar longitud m�nima y m�xima de la cadena de texto
    public function validaTexto($text, $min = false, $max = false, $espacios = true, $mensaje = '')
    {
        if (!empty($min)) {
            if (strlen($text) < $min) {
                $this->error[] = $mensaje;
                return false;
            }
        }
        if (!empty($max)) {
            if (strlen($text) > $max) {
                $this->error[] = $mensaje;
                return false;
            }
        }
        if ($espacios) {
            $res = ereg("^[A-Za-z0-9\ ]+$", $text);
        } else {
            $res = ereg("^[A-Za-z0-9]+$", $text);
        }
        if ($res) {
            return true;
        } else {
            $this->error[] = $mensaje;
            return false;
        }
    }
    // Validaci�n de direcciones de email
    public function validaEmail($email, $dominio = '', $mensaje = '')
    {
        $res = ereg("^[^@ ]+@[^@ ]+\.[^@ \.]+$", trim($email));
        if ($res) {
            return true;
        } else {
            $this->error[] = $mensaje;
            return false;
        }
    }
    
    // Validaci�n de n�meros
    public function validaNumero($num, $min = false, $max = false, $mensaje = '')
    {
        if (is_numeric($num)) {
            if ($num < $min or $num > $max) {
                $this->error[] = $mensaje;
                return false;
            } else {
                return true;
            }
        } else {
            $this->error[] = $mensaje;
            return false;
        }
    }
    //Validaci�n de fechas
    public function validaFecha($fecha, $mensaje = '')
    {
        if (($ts = strtotime($fecha)) === false) {
            $this->error[] = $mensaje;
            return false;
        } else {
            return true;
        }
    }
    //Validaci�n de upload de archivos
    public function validaUpload($file, $max = false, $exts = false, $mensaje = '')
    {
        //Validamos el peso del archivo
        //El peso debe pasarse en bytes
        if ($max) {
            if ($file['size'] > $max) {
                $this->error[] = $mensaje;
                return false;
            }
        }
        
        //Validamos la extensi�n del archivo
        //El par�metro $exts contendr� en un array las extensiones permitidas para luego, utilizando la funci�n in_array, verificar si se encuentra habilitada
        if (!empty($exts)) {
            $ext = explode('.', basename(strtolower(trim($file['name']))));
            if (!in_array($ext[count($ext) - 1], $exts)) {
                $this->error[] = $mensaje;
                return false;
            }
        }
        return true;
    }
    public function getEstado()
    {
        if (count($this->error) > 0) {
            return $this->error;
        } else {
            return false;
        }
    }
}