<?php

// ---
// Nom : bdd.php
// Par : Nicolas Montfort
// Le : 11 decembre 2012
// Description : Connexion à la base de données
// ---

require_once 'config.php';
require_once 'pdoconfig.php';

class Bdd
{
	private static $pdo = NULL;
	
	public function Bdd()
	{
	}
	
	public function getConnexion()
	{
		if( is_null(Bdd::$pdo) )
		{		
			try
			{
				Bdd::$pdo = new pdoconfig(DB_ENGINE.':host='.DB_URL.';dbname='.DB_NAME,DB_USER,DB_PWD); //;port='.DB_PORT.'
			}
			catch(Exception $e)
			{
				die();
				//echo "Echec : " . $e->getMessage();  
			}
		}
		return Bdd::$pdo;
	}
}
?>
