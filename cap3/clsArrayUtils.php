<?php
class arrayUtils {
private $arr;
private $orden;
public function __construct($arr) {
$this->arr = (array)$arr;
}
public function agregarElemento($valor,$indice=false)
{
if(!$indice) {
$this->arr[] = $valor;
} else {
if(is_int($indice)) {
$this->arr[(int)$indice] = $valor;
} else {
$this->arr[(string)$indice] = $valor;
}
}
}
public function eliminarElemento($indice) {
if(is_int($indice)) {
if(isset($this->arr[(int)$indice])) {
unset($this->arr[(int)$indice]);
return true;
} else {
return false;
}
} else {
if(isset($this->arr[(string)$indice])) {
unset($this->arr[(string)$indice]);
return true;
} else {
return false;
}
}
}
public function setOrden($indice='',$direccion='ASC')
{
$this->orden['indice'] = $indice;
$this->orden['direccion'] = $direccion;
}
public function ordenar() {
if($this->orden['direccion'] == 'ASC') {
usort($this->arr, array($this,"cmpAsc"));
} else {
usort($this->arr,array($this,"cmpDesc"));
}
}
private function cmpAsc($a, $b)
{
return strcmp($a[$this->orden['indice']],$b[$this->orden['indice']]);
}
private function cmpDesc($a, $b)
{
return strcmp($b[$this->orden['indice']],$a[$this->orden['indice']]);
}

public function vaciarArray() {
$this->arr = array();
$this->orden = array();
}

public function verArray(){
return $this->arr;
}