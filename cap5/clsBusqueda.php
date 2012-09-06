<?php
class Busqueda {
 
 	private $db;
 	public $debug;
 	public $total;
 
 	public function __construct($db) {
 		$this->db = $db;
 		$this->total = null;
	}

	public function Buscar($tabla,$resultado='*',
							$campos,$criterios,
							$comparador='=',
							$orden=null,
							$paginado=false,
							$pagina=null,
							$porpagina=null) {
	
		$query = "SELECT ";

		if($paginado) {		
			$query .= "SQL_CALC_FOUND_ROWS ";
		}
		
		if($resultado != '*') {
		
			$res = explode(',',$resultado);
		
			for($r=0;$r<count($res);$r++) {
			
				$query .= $res[$r];
				
				if($r+1<count($res)) $query .= ', ';
			
			}
		
		} else {
			$query .= "*";
		}
		
		$query .= " FROM " . $tabla . " WHERE ";
		
		$campos = explode(',',$campos);
		$criterios = explode(',',$criterios);
		
		for($i=0;$i<count($campos);$i++) {
					
			for($j=0;$j<count($criterios);$j++) {
				
					$query .= $campos[$i] . " ";
					
					if(strtoupper($comparador) == 'LIKE') {
						$query .= $comparador . " '%" . $this->db->filtrar($criterios[$j]) . "%'";
					} else {
						$query .= $comparador . " '" . $this->db->filtrar($criterios[$j]) . "'";
					}
					
					if($j+1 <count($criterios)) { 
						$query .= " OR ";
					}
			}

				if($i+1 <count($campos	)) { 
					$query .= " OR ";
				}
			
		}
		
		if(!empty($orden)) {
		
			$query .= " ORDER BY ";
		
			$campos = explode(',',$orden);
					
			for($o=0;$o<count($campos);$o++) {
			
				$orden = explode(':',$campos[$o]);
			
				$query .= $orden[0] . " " . strtoupper($orden[1]);
			
				if($o+1<count($campos)) $query .= ", ";
		
			}
			
			
		}

		if($paginado) {
			$query .= " LIMIT " . $pagina*$porpagina . ", " . $porpagina;	
		}


		if($this->debug) {
			echo "------------<br>";
			echo $query;
			echo "<br>------------<br>";
		}
								
		$resultados = $this->db->enviarQuery($query);
		
		if($paginado && !isset($this->total) ) {
		
			$total = $this->db->enviarQuery("SELECT FOUND_ROWS() AS total");
		
			if(!empty($total)) {
			
				$this->total = $total[0]['total'];
			
			}
		}
		
		return $resultados;
	}


}