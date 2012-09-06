<?php 
class MySQLServer
{

	private $hostname;
	private $usuario;
	private $password;
	private $base;
	
	private $conexion;
	public $error;
	
	public $useCache = false;
	public $mcHost = 'localhost';
	public $mcPuerto = '11211';
	public $mcTiempo = '3600';

	public function __construct($hostname,$usuario,$password,$base) {
	
		$this->hostname = $hostname;
		$this->usuario = $usuario;
		$this->password = $password;
		$this->base = $base;
	
		if(!$this->_connect()) {
			$this->error = mysql_error();
		}
	}
  	
  	private function _connect(){
  	
  		$this->conexion = mysql_connect($this->hostname,$this->usuario,$this->password);
  		if($this->conexion) {
  			mysql_select_db($this->base,$this->conexion);
  		} else {
  			$this->error = mysql_error();
  			return false;
  		}
  	}

	public function filtrar($valor){
	      	$valor = stripslashes($valor);
			return mysql_real_escape_string( $valor );
	}
  	
  	public function enviarQuery($query) {
  	
  		$tipo = strtoupper(substr(ltrim($query),0,6));
  	
  		switch($tipo) {
  			case 'SELECT' :
  			
  				if($this->useCache) {
  					//Usamos cache
  					$memcache = new Memcache();
  					$memcache->connect($this->mcHost,$this->mcPuerto);
  			
  					//Definimos la clave bajo la cual almacenar los resultados
  					$clave = md5($query);
  					
  					//Chequeamos si esta en memoria
  					$resultado = $memcache->get($clave);
 
   					if(empty($resultado)) {
  						//No esta en cache hay que buscarlo en la base de datos
						$resultado = mysql_query($query,$this->conexion);
			
						if(!$resultado) {
							$this->error = mysql_error();
						} else {
							if(mysql_num_rows($resultado) == 0) {
								return false;
							} else {
								while($f = mysql_fetch_assoc($resultado)) {
									$r[] = $f;
								}
								mysql_free_result($resultado);
							}

							echo "No estaba en memoria, viene de la base";
							$memcache->set($clave,$r,false,$this->mcTiempo); //cacheado por 1 hora
							return $r;
						}					
					} else {
					  	echo "Viene de memoria";
  						return $resultado;
					}
				} else {
					//No usamos cache
						$resultado = mysql_query($query,$this->conexion);
			
						if(!$resultado) {
							$this->error = mysql_error();
						} else {
							if(mysql_num_rows($resultado) == 0) {
								return false;
							} else {
								while($f = mysql_fetch_assoc($resultado)) {
									$r[] = $f;
								}
								mysql_free_result($resultado);
							}

							return $r;
						}					
					
				}
	 			
 			break;
  			
  			case 'INSERT' :
  				$resultado = mysql_query($query,$this->conexion);
  				if(!$resultado) {
  					$this->error = mysql_error();
  				} else {
					return mysql_insert_id();
				}				  			
  			break;
  			
  			case 'DELETE' :
  			case 'UPDATE' :
  				$resultado = mysql_query($query,$this->conexion);
  				if(!$resultado) {
  					$this->error = mysql_error();
  				} else {
					return mysql_affected_rows();
				}				  			
  			break;
  			
  			default:
  			$this->error = "Tipo de consulta no permitida";
  		}
  	}
  	
}
?>
<?php
$mtime = microtime();
$mtime = explode(" ",$mtime);
$mtime = $mtime[1] + $mtime[0];
$starttime = $mtime;

$db = new MySQLServer('localhost','root','','latam');
$db->useCache = false;
$resultado = $db->enviarQuery('SELECT noticia_id, noticia_titulo FROM noticia LIMIT 10');

$mtime = microtime();
$mtime = explode(" ",$mtime);
$mtime = $mtime[1] + $mtime[0];
$endtime = $mtime;
$totaltime = ($endtime - $starttime);
   
echo "La consulta demoro ".$totaltime." segundos"; 
?>