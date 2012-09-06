<?php 
class SQLiteServer
{

	private $sl_archivo;

	private $conexion;
	public $error;
	
	public function __construct($archivo) {
	
		$this->sl_archivo = $archivo;
	
		if(!$this->_connect()) {
			$this->error = $this->conexion->lastError();
		}
	}
  	
  	private function _connect(){
  	
  		$this->conexion = new SQLiteDatabase($this->sl_archivo,0666,$this->error);
  		if(!$this->conexion) {
  			$this->error = $this->conexion->lastError();
  			return false;
  		}
  	}

	public function filtrar($valor){
	      	$valor = stripslashes($valor);
			$valor = ltrim($valor);
			$valor = rtrim($valor);	      	
			return addslashes($valor);
	}
  	
  	public function enviarQuery($query) {
  	
  		$tipo = strtoupper(substr(ltrim($query),0,6));
  	
  		switch($tipo) {
  			case 'SELECT' :
  			
  						$resultado = $this->conexion->query($query);
			
						if(!$resultado) {
							$this->error = $this->conexion->lastError();
						} else {
												
						
							if($resultado->numRows() == 0) {
								return false;
							} else {
								while($f = $resultado->fetch()) {
									$r[] = $f;
								}
							}

							return $r;
						}					
	 			
 			break;
  			
  			case 'INSERT' :
  				$resultado = $this->conexion->query($query);
  				if(!$resultado) {
  					$this->error = $this->conexion->lastError();
  				} else {
					return $this->conexion->lastInsertRowid();
				}				  			
  			break;
  			
  			case 'DELETE' :
  			case 'UPDATE' :
  				$resultado = $this->conexion->query($query);
  				if(!$resultado) {
  					$this->error = $this->conexion->lastError();
  				} else {
					return true;
				}				  			
  			break;
  			
  			default:
  		  	$this->error = "Tipo de consulta no permitida";
  		}
  	}
  	
  	public function __destruct(){
		@$this->conexion->close();
	}

  	
}
?>
<?php
$db = new SQLiteServer('/tmp/recetas.sqlite');
$resultado = $db->enviarQuery("SELECT * from Movies ");

echo $db->error;

echo "<pre>";
print_r($resultado);

?>