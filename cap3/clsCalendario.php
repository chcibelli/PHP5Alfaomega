<?php
require("clsDateUtils.php");

class calendario extends dateUtils {
	
	private $dias = array('Domingo','Lunes','Martes','
							Miercoles','Jueves','Viernes','Sabado');
	
	
	private $meses = array('Enero','Febrero','Marzo','Abril','Mayo',
							'Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
	
	private $eventos = array();
	
	private $fecha = array();

	public function setDias($arrDias) {
	
		if(count($arrDias) == 7) {
			$this->dias = $arrDias;
			return true;
		} else {
			return false;
		}
		
	}
	
	public function setMeses($arrMeses) {
	
		if(count($arrDias) == 12) {
			$this->meses = $arrMeses;
			return true;
		} else {
			return false;
		}
		
	}

	public function agregarEvento($dia,$mes,$anio,$titulo,$detalle='') {
	
		(int)$dia;
		(int)$mes;
		(int)$anio;
				
		$this->eventos[$anio][$mes][$dia][] = array('titulo' => $titulo, 'detalle' => $detalle);
	
	}

	public function eliminarEvento($dia,$mes,$anio,$indice) {
		(int)$dia;
		(int)$mes;
		(int)$anio;
		(int)$indice;
				
		unset($this->eventos[$anio][$mes][$dia][$indice]);

	}
	
	public function getEventos() {
	
		return $this->eventos;
	
	}
				
	public function getCalendario($anio,$mes) {
		
		$tfecha = $anio.'-'.$mes.'-'.date('d');
		
		$this->fecha = parent::formateaFecha($tfecha);	
				
		if($this->fecha == 'error') {
			return 'error';
		}
				
		$fila = 0;
		$filas = 5;
		
		//Verificamos si es bisiesto
		if (! checkdate(2, 29, $this->fecha ['anio']) ) {
			if ($mes == 2) {
				$d = getdate ( strtotime ( $this->fecha ['anio'] . '-2-1' ) );
				if ($d ['wday'] == 0) {
					$filas --;
				}
			}
		}
				
		//Abrimos el contenedor del calendario
		$html = '<div id="calendario">';
		
		//Encabezado del calendario
		$html .= '<table><tr>';
			$html .= '<td id="dias" colspan="7"><b>'.$this->meses[$mes-1].' '.$this->fecha ['anio'].'</b></td>';
		$html .= '</tr>';
		
		//Armamos la fila de dias
		$html .= '<tr>';
		for($i=0;$i<count($this->dias);$i++) {
			$html .= '<td><b>'.$this->dias[$i].'</b></td>';
		}
		$html .= '</tr>';


		$cantidadDiasMes = date('t',strtotime($this->fecha ['anio'].'-'.$this->fecha['mes'].'-01'));
		
		$diaActual = 1;
	
		while ( $fila < $filas ) {
			$html .= '<tr>';
			for($i = 0; $i < 7; $i ++) {
				if (($fila == 0 && $i < date('w',strtotime($this->fecha ['anio'].'-'.$this->fecha['mes'].'-01')) ) || ($diaActual > $cantidadDiasMes)) {
					$html .= '<td></td>';
				} else {
						$html .= $this->analizaDia($diaActual);
					$diaActual ++;
				}
			}
			$html .= '</tr>';
			$fila ++;
		}
		
		$html .= '</table>';
		$html .= '</div>';

		return $html;
	
	}
	
	
	private function analizaDia($dia) {	
		//Aplicamos el estilo que corresponda al dia
		if(strtotime($this->fecha['anio'].'-'.$this->fecha['mes'].'-'.$dia) 
			== 
			strtotime(date('Y').'-'.date('m').'-'.$this->fecha['dia']) ) {
			$estilo = 'id="hoy"';
		} else {
			$estilo = 'id="dia"';
		}
		
		//Coloreamos los fines de semana
		if(date('w',strtotime($this->fecha['anio'].'-'.$this->fecha['mes'].'-'.$dia)) == 0 || 
			date('w',strtotime($this->fecha['anio'].'-'.$this->fecha['mes'].'-'.$dia)) == 6 ) {
			$estilo = 'id="finde"';
		}
			
		//Si hay eventos para el anio, mes y dia actual		

		if(!empty($this->eventos[$this->fecha['anio']][$this->fecha['mes']][$dia])) {

			foreach($this->eventos[$this->fecha['anio']][$this->fecha['mes']][$dia] as $evento) {
			
				$eventos .= "<div><span id='eventos'>".$evento['titulo']." (".$evento['detalle'].")</span></div>";
			}

		}
								
		$html = "<td ".$estilo." >$dia<div></div>" . $eventos . '</td>';
		
		return $html;
	
	}
		
}