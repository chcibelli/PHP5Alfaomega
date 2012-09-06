<?php
class CookieUtils
{

  const DefaultLife = 3600; //3600 segundos de duracion = 1 hora

  public function get($name)
  {
  	if(isset($_COOKIE[$name])) {
    	return $_COOKIE[$name];
  	} else {
    	return false;
  	}
  }


  public function set($name, $value, $expiry = self::DefaultLife, $path = '/', $domain = false)
  {
    $val = false;
    if (!headers_sent())
    {
      if ($domain === false) {
        $domain = $_SERVER['HTTP_HOST'];
	  }
	  
      if ($expiry === -1) {
        $expiry = 1893456000;
      } elseif (is_numeric($expiry)) {
        $expiry += time();
      } else {
        $expiry = strtotime($expiry);
      }

      $val = @setcookie($name, $value, $expiry, $path, $domain);
    }

    return $val;
  }

  public function delete($name, $path = '/', $domain = false)
  {
    $val = false;
    if (!headers_sent())
    {
      if ($domain === false) {
        $domain = $_SERVER['HTTP_HOST'];
      }
      
      $val = setcookie($name, '', time() - 3600, $path, $domain);
      unset($_COOKIE[$name]);
    }
    
  }
 
  public function getAllCookies() {
  	
  	if(!empty($_COOKIE)) {
  		return array_keys($_COOKIE);
  	} else {
  		return false;
  	}
  }
 
  public function deleteAllCookies() {
  	
  	$c = self::getAllCookies();
  	
	if(!empty($c)) {
		for($i=0;$i<count($c);$i++) {
			self::delete($c[$i]);
		}
	}
  }
  	
}

class LoginHttp extends CookieUtils {

	private static $loggedin = false;
	public static $arrUsuario = array();
	
	//Datos de prueba
	private static $user = 'test';
	private static $password = 'test';
	
	private static $mensajes = array('ingreso'=>'Ingrese su usuario y password\n',
									 'error'=>'Usted no tiene permisos para acceder\n');
	//
		
	public function protect() {
		 if(empty($_SERVER['PHP_AUTH_USER'])) {		
		 header('WWW-Authenticate: Basic realm="'.self::$mensajes['ingreso'].'"'); 
		 header('HTTP/1.0 401 Unauthorized');
 	 	 echo self::$mensajes['error'];
		 exit();
		 } else {		 	
		 	if(self::checkLogin()) {
		 		//Redirigimos al usuario al contenido que no tenia permitido
		 		header("Location: http://www.google.com");
		 	} else {
		 		self::protect();
		 	}
		 }
	}
	
	public function checkLogin() {
		
		$usr = $_SERVER['PHP_AUTH_USER'];
		$pass = $_SERVER['PHP_AUTH_PW'];
		
		if($usr == self::$user && $pass == self::$password) {
		
			self::$loggedin = true;
			
			self::$arrUsuario['user'] = self::$user; //Aqui guardamos el dato que volvio de la db
			self::$arrUsuario['password'] = md5(self::$password); //Aqui guardamos el dato que volvio de la db
	
			return true;
	
		} else {		
			$_SERVER['PHP_AUTH_USER'] = '';
			$_SERVER['PHP_AUTH_PW'] = '';
			self::$arrUsuario = array();
			self::$loggedin = false;
			return false;
		}
		
	}
	
	public function logout() {
			$_SERVER['PHP_AUTH_USER'] = '';
			$_SERVER['PHP_AUTH_PW'] = '';
			self::$arrUsuario = array();			
			self::$loggedin = false;
	}

}

$auth = new LoginHttp();
$auth->protect();