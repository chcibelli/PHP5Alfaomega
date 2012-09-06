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

class Login extends CookieUtils {

	private static $loggedin = false;
	private static $intentos = 0;
	public static $arrUsuario = array();

	//Datos de prueba
	private static $user = 'test';
	private static $password = 'test';
	//
	
	
	public function auth() {
	
		self::$loggedin = false;
		if(!self::checkCookie()) {
			self::checkSession();
		}
		
		return self::$loggedin;
	
	}
	
	private function checkCookie() {
		if(!empty($_COOKIE['auth_user']) && !empty($_COOKIE['auth_pass'])) {
			return self::checkLogin($_COOKIE['auth_user'],$_COOKIE['auth_pass']);
		} else {
			return false;
		}
	}
	
	private function checkSession() {
		if(!empty($_SESSION['auth_user']) && !empty($_SESSION['auth_pass'])) {
			return self::checkLogin($_SESSION['auth_user'],$_SESSION['auth_pass']);
		} else {
			return false;
		}
	}
	
	
	public function checkLogin($usr='', $pass='') {
	
		/*inicialmente validaremos contra datos preestablecidos 
		que podrian venir por ejemplo de una base de datos */
	
		$usr = mysql_real_escape_string($usr);
		$pass = mysql_real_escape_string($pass);
		
		if($usr == self::$user && $pass == self::$password) {
		
			self::$intentos = 0;
			self::$loggedin = true;
			
			self::$arrUsuario['user'] = self::$user; //Aqui guardamos el dato que volvio de la db
			self::$arrUsuario['password'] = md5(self::$password); //Aqui guardamos el dato que volvio de la db
	
			$_SESSION['auth_user'] = self::$user;
			$_SESSION['auth_pass'] = self::$password;
			parent::set("auth_user", self::$user);
			parent::set("auth_pass", self::$password);
					
			return true;
	
		} else {		
			self::$intentos++;
			self::$arrUsuario = array();
			self::$loggedin = false;
			return false;
		}
		
	}
	
	public function logout() {
			self::$arrUsuario = array();
			unset($_SESSION['auth_user']);
			unset($_SESSION['auth_pass']);
			parent::delete('auth_user');
			parent::delete('auth_pass');
			
			self::$loggedin = false;
	}

}

$auth = new Login();

if($auth->checkLogin('test','test')) {
	echo "ok";

	print_r($_SESSION);
	print_r($_COOKIE);

} else {
	echo 'no ok';
}