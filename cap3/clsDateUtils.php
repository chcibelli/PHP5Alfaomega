<?php
class dateUtils {

	//Cortando cadenas de manera prolija
		public function cortaStrings($text,$longitud,$html=false) {
	
	$final = '';
	$total = 0;
	
    foreach (explode(' ', $text) as $word)
    {
	
		if($word != '') {
			$final .= ' ' . $word;
			$total += strlen($word);
		}
		
		
		//Ya se supero el limite establecido, salimos del foreach, antes cerremos los tags!
		if($total >= $longitud) {
		$final .= "...";
		$tags_apertura    = "%((?<!</)(?<=<)[\s]*[^/!>\s]+(?=>|[\s]+[^>]*[^/]>)(?!/>))%"; 
		$tags_cierre = "|</([a-zA-Z]+)>|";

		//Buscamos los tags html que abren para cerrarlos
		if( preg_match_all($tags_apertura,$final,$aBuffer) ) { 
								
			if( !empty($aBuffer[1]) ) {
				
				preg_match_all($tags_cierre,$final,$aBuffer2);

                if( count($aBuffer[1]) != count($aBuffer2[1]) ) { 

					$aBuffer[1] = array_reverse($aBuffer[1]);
				
                    foreach( $aBuffer[1] as $index => $tag ) { 
					
                        if( empty($aBuffer2[1][$index]) || $aBuffer2[1][$index] != $tag) 
                            $final .= '</'.$tag.'>'; 
                    } 
                } 				
				
			}
		}
			break;
		}
    }
	
	return $final;	
	}


	//Analizando palindromos
	public function esPalindromo($str) {
		
		//Tratamos como string el parametro enviado
		(string)$str;
		
		if(strlen($str) == 1) {
			return true;
		} else {
			//Limpiamos la cadena
			$str = $this->limpiaCadena($str);	
			
			//Verificamos si se leen igual en ambos sentidos
			if(strrev($str) == $str) {
				return true;
			} else {
				return false;
			}
		}
	}
	
	private function limpiaCadena($str) {
	
			//Tags HTML
			$str = strip_tags($str);
			
			//Espacios
			$str = str_replace(' ','',strtolower($str));
			
			//Acentos
			$p = array('/á/','/é/','/í/','/ó/','/ú/');
			$r = array('a','e','i','o','u');
			$str = preg_replace($p, $r, $str);
			//Acentos HTML		
			$p = array('/&aacute;/','/&eacute;/','/&iacute;/','/&oacute;/','/&uacute;/');
			$r = array('a','e','i','o','u');
			$str = preg_replace($p, $r, $str);		
	
			//Signos de puntuacion
			$str = preg_replace ('/&.+?;/','', $str);	
			$str = str_replace(',','',$str);			
	
			return $str;
	}

	private $longitud_salt = 5;

	public function encodeaString($str, $modo='md5'){ 
				
		//Generamos el salto aleatorio con la longitud definida
		$salt = substr(uniqid(rand(),true),0,$this->longitud_salt);	
				
		if(in_array($modo,hash_algos())) {

		//Generamos el hash del password junto al salt
        $out = hash($modo, $salt.$str); 

        return $this->longitud_salt.$out.$salt; 

		} else {
		return "error algoritmo no soportado";
		}
    } 

	public function deHash($str) {
	
		$arrHash['longitud'] = substr($str,0,1);
		$arrHash['hash'] = substr($str,1,strlen($str)-($arrHash['longitud']+1));
		$arrHash['salt'] = str_replace($arrHash['hash'],'',substr($str,1));
		$arrHash['evaluar'] = $arrHash['salt'].$arrHash['hash'];
		
		return $arrHash;
	
	}
	
	public function randomString($longitud=8) {

		$caracteresValidos=array("b","B","c","C","d","D","f","F","g","G","h","H","j","J","k","K","l","L",
						"m","M","n","N","p","P","q","Q","r","R","s","S","t","T","v","V","w","W","x","X",
						"y","Y","z","Z","a","A","e","E","i","I","o","O","u","U",
						".","/","$","!","@","#","%","(",")","&",":","\\","=","+",
						"[","]","{","}",":",";",",","^","*","-","_",
						"0","1","2","3","4","5","6","7","8","9");

		$i=0;
		$rStr = "";
		while($i<$longitud) {
			
			$caracter = $caracteresValidos[mt_rand(0,count($caracteresValidos))];
			if(!strstr($rStr,$caracter)) {
				$rStr .= $caracter;
				$i++;
			}
			
		}

		return $rStr;

	}
	
	public function medirSeguridadString($str) {
	
		$seguridad = 0;
		
		//Verificamos la longitud del string
		if(strlen($str) >= 8) {
			$seguridad++;
		}
		
		if(strlen($str) >= 16) {
			$seguridad++;
		}
		
		//Chequeamos que tenga mayusculas y minusculas
		if(strtoupper($str) != $str) {
			$seguridad++;
		}
		
		//Chequeamos cuantos simbolos contiene
	    preg_match_all('/[!@#$%&*\/=?,;.:\-_+^\\\]/', $str, $simbolos);
    	$seguridad += sizeof($simbolos[0]);
	
		//Verificamos caracteres unicos
		$unicos = sizeof(array_unique(str_split($str)));
		$seguridad += $unicos;
		
		//Chequeamos cantidad de caracteres iguales consecutivos
		$arrStr = str_split($str);
		$consec = 0;
		for($i=1;$i<count($arrStr);$i++) {
			if($arrStr[$i-1] == $arrStr[$i]) {
				$consec++;
			}
		}
		$seguridad = $seguridad - $consec;
					
		return $seguridad;
		
	}
	
	public function calculaEdad($fechaNacimiento){
		
		//Reemplazamos la barras por guiones para normalizar la fecha
		$fechaNacimiento = str_replace('/','-',$fechaNacimiento);
		$fechaNacimiento = str_replace('.','-',$fechaNacimiento);
		$fechaNacimiento = str_replace(':','-',$fechaNacimiento);
		
		$posAnio = -1;
		
		//Nos aseguramos que posea 3 elementos
		$arrFecha = explode('-',$fechaNacimiento,3);
		if(sizeof($arrFecha) == 3) {
			//Buscamos el anio para encontrar el resto de los elementos
			$i=0;
			while($i<sizeof($arrFecha)) {
				if(strlen($arrFecha[$i]) == 4) {
					$posAnio = $i;
					break;
				}
				$i++;
			}
		
		} else {
			return 'error';
		}
		
		if($posAnio < 0 ) {
			return 'error';
		}
	
		//De acuerdo a la ubicacion del anio (principio o final), ubicamos dia y mes
		//YYYY-MM-DD
		//DD-MM-YYYY
		//
		if($posAnio == 0) { $posDia = 2; $posMes = 1; }
		if($posAnio == 2) { $posDia = 0; $posMes = 1; }
		
		//Armamos la fecha de nacimiento final
		$fechaNacimiento = $arrFecha[$posAnio] . "-" . $arrFecha[$posMes] . "-" . $arrFecha[$posDia];
	
		//Verificamos que la fecha obtenida sea valida
		if (($ts = strtotime($fechaNacimiento)) === false) {
			return 'error';
		} else {
		
		//Calculamos la diferencia entre la fecha actual
		$anio_diff  = date("Y") - $arrFecha[$posAnio];
		$mes_diff = date("m") - $arrFecha[$posMes];
		$dia_diff   = date("d") - $arrFecha[$posDia];
		
		//Si no existe diferencia en el dia o mes aun no cumplio, descontamos uno
		if ($dia_diff < 0 || $mes_diff < 0)
		  $anio_diff--;

		return (int)$anio_diff;
		
		}
		
	}
		
	public function calculaEdad1($fechaNacimiento){
				
		//Trabajamos unicamente con la fecha en formato YYYY-MM-DD (2010-08-30)
		$fechaNacimiento = str_replace('-','',$fechaNacimiento);
		
		//Calculamos la diferencia
		$anio_diff  = date("Y") - substr($fechaNacimiento,0,4);
		$mes_diff = date("m") - substr($fechaNacimiento,5,2);
		$dia_diff   = date("d") - substr($fechaNacimiento,7,2);

		//Si no existe diferencia en el dia o mes aun no cumplio, descontamos uno
		if ($dia_diff < 0 || $mes_diff < 0)
		  $anio_diff--;

		return (int)$anio_diff;
		
	}


	public function formateaFecha($fecha) {

		//Reemplazamos la barras por guiones para normalizar la fecha
		$fecha = str_replace('/','-',$fecha);
		$fecha = str_replace('.','-',$fecha);
		$fecha = str_replace(':','-',$fecha);
		
		$posAnio = -1;
		
		//Nos aseguramos que posea 3 elementos
		$arrFecha = explode('-',$fecha,3);
		
		if(sizeof($arrFecha) == 3) {
			//Buscamos el anio para encontrar el resto de los elementos
			$i=0;
			while($i<sizeof($arrFecha)) {
				if(strlen($arrFecha[$i]) == 4) {
					$posAnio = $i;
					break;
				}
				$i++;
			}
		
		} else {
			return 'error';
		}
		
		if($posAnio < 0 ) {
			return 'error';
		}
	
		if($posAnio == 0) { $posDia = 2; $posMes = 1; }
		if($posAnio == 2) { $posDia = 0; $posMes = 1; }
		
		$rfecha['dia'] = $arrFecha[$posDia];
		$rfecha['mes'] = $arrFecha[$posMes];
		$rfecha['anio'] = $arrFecha[$posAnio];
		
		return $rfecha;
	}
	
	public function restarFechas($fechaInicio,$fechaFin=false,$res='dias') {
	
			$fechaInicio = $this->formateaFecha($fechaInicio);
		if(!$fechaFin) {
			$fechaFin = date('Y-m-d');
		} else {
			$fechaFin = $this->formateaFecha($fechaFin);
		}
		
		$tsFin = mktime(0,0,0,$fechaFin['mes'],$fechaFin['dia'],$fechaFin['anio']);
		$tsInicio = mktime(0,0,0,$fechaInicio['mes'],$fechaInicio['dia'],$fechaInicio['anio']);
				
		switch(strtolower($res)) {
		case 'dias':
			//El resultado esta en segundos, lo pasamos a minutos, horas y dias
			return round(($tsFin - $tsInicio) / (60 * 60 * 24));
			break;
		case 'horas':
			//El resultado esta en segundos, lo pasamos a minutos, horas y dias
			return round(($tsFin - $tsInicio) / (60 * 60));
			break;
		case 'minutos':
			//El resultado esta en segundos, lo pasamos a minutos, horas y dias
			return round(($tsFin - $tsInicio) / (60));
			break;
		case 'segundos':
			//El resultado esta en segundos, lo pasamos a minutos, horas y dias
			return round(($tsFin - $tsInicio));
			break;				
		}
	}
	
	public function calcularPorcentaje($total,$valor,$decimales=2) {
	
		(int)$decimales;
		(float)$total;
		(float)$valor;
	
		return round(($valor * 100) / $total,$decimales);
	
	}
		
}