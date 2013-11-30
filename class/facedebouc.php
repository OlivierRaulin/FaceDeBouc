<?php
// ---
// Nom : facebouc.php
// Par : Axel Guilmin
// Le : 1er decembre 2012
// Description : Helper pour les parties communes a toutes les pages
// ---

// Inclure les classes dont on a besoin partout
require_once 'config.php';
require_once 'template.php';
require_once 'user.php';
require_once 'bdd.php';
require_once 'pbkdf2.php';
require_once 'template.php';
require_once 'timer.php';
require_once 'Text/CAPTCHA.php';

/*$_DB = new Bdd();
global $_DB;

$_USER = new User($_DB->getConnexion());
global $_USER;*/

class Facedebouc
{
	// Methode appelle au debut de chaque controlleur php
	public static function begin()
	{	
		// Rendre les log plus simple a lire
		/*if(DEBUG)
			trigger_error("- - - - - - " . $_SERVER["REQUEST_URI"] . " - - - - - -");*/
		
		// Maintenir la session
		Facedebouc::session();
		
		// Definir le niveau de reporting
		error_reporting(0); // 0 = Aucun, E_ALL = Tous
		// en prod il faut le laisser en 0
		
		// Creer Bdd
		global $_DB;
		$_DB = new Bdd();
		
		// Creer user
		global $_USER;
		$_USER = new User($_DB->getConnexion());
		
	}
	
	private static function session()
	{
		session_start();

		$IP = (getenv ( "HTTP_X_FORWARDED_FOR" )) ? getenv ( "HTTP_X_FORWARDED_FOR" ) : getenv ( "REMOTE_ADDR" );
				
		if( ! isset($_SESSION['ip']) )
		{
			$_SESSION['ip'] = $IP;
		}
		else if( $_SESSION['ip'] != $IP )
		{
			$_SESSION = array();
			session_destroy();
			
			Facedebouc::errorMessage('Hého, pirate !');
			header('location:http://www.youtube.com/watch?v=16WY0ruy2io');
			die();
		}
	}
	
	public static function errorMessage($message)
	{
		$_SESSION['error'] = $message;
	}
	
	public static function VerifierAdresseMail($adresse)  
	{  
	   $Syntaxe='#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';  
	   if(preg_match($Syntaxe,$adresse))  
	      return true;  
	   else  
	     return false;  
	}
	
	public static function methodShallBe($method)
	{
		if($_SERVER['REQUEST_METHOD'] != $method)
		{
			Facedebouc::errorMessage('Hého, pirate !');
			header('location:http://www.youtube.com/watch?v=16WY0ruy2io');
			die();
		}
	}
}
?>