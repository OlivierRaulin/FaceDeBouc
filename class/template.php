<?php
// ---
// Nom : template.php
// Par : Axel Guilmin
// Le : 1er decembre 2012
// Description : Quelques simplifications pour la classe PHPLIB de Pear
// ---

require_once 'HTML/Template/PHPLIB.php';
require_once 'user.php';
require_once 'bdd.php';

class Template extends HTML_Template_PHPLIB
{	
	private $name;

	public function getName()
	{
		return $this->name;
	}
			
	public function Template($name)
	{
		parent::__construct(dirname(__FILE__).'/../tpl/', 'remove');
		$this->name = $name;
		$this->setFile('head','common/head.tpl');
		$this->setFile('top','common/top.tpl');
		$this->setFile('sidebar','common/sidebar.tpl');
		$this->setFile($name, $name.".tpl");
		$this->setFile('bottom','common/bottom.tpl');
	}
	
	// Afficher le rendu d'un template
	public function draw()
	{		
		$this->setTopVars();
		$this->setSidebarVars();
		
		// Toutes les pages sont envoyes en utf-8
		header("Content-type: text/html; charset=utf-8");
		// Parser et envoyer le template
		echo $this->finish($this->parse('OUT', 'head'));
		echo $this->finish($this->parse('OUT', 'top'));
		echo $this->finish($this->parse('OUT', 'sidebar'));
		echo $this->finish($this->parse('OUT', $this->name));
		echo $this->finish($this->parse('OUT', 'bottom'));
	}
	
	// Methode identique a celle de Pear, mais sans le premier param
	/*public function setBlock($authorline, $authorline_ref);
	{
		parent::->setBlock($this->name, $authorline, $authorline_ref);	
	}*/
	
	private function setTopVars()
	{
		$bdd = new Bdd();
		$user = new User($bdd->getConnexion());
		
		$this->setBlock('top', 'hiUser', 'hiUser_ref');
		$this->setBlock('top', 'logInForm', 'logInForm_ref');
		$this->setBlock('top', 'error', 'error_ref');

		if($user->isLogged)
		{
			// User is logged
			$this->setVar('username', $user->fullname);
			$this->setVar('userid', $user->id);
			$this->parse('hiUser_ref', 'hiUser', true);
			$this->clearVar('logInForm_ref') ;
		}
		else
		{
			// User is not logged
			$this->clearVar('hiUser_ref') ;
			$this->parse('logInForm_ref', 'logInForm', true);
		}
		
		if(isset($_SESSION['error']))
		{
			$this->setVar('error.message', $_SESSION['error']);
			$this->parse('error_ref', 'error', true);
			unset($_SESSION['error']);
		}
		else
		{
			$this->clearVar('error_ref');
		}
	}
	
	private function setSidebarVars()
	{
		$this->setBlock('sidebar', 'profil', 'profil_ref');
		$this->setBlock('sidebar', 'admin', 'admin_ref');
		
		$bdd = new Bdd();
		$user = new User($bdd->getConnexion());
		
		if($user->isLogged)
		{		
			$this->parse('profil_ref', 'profil', true);
		}
		else
		{
			$this->clearVar('profil_ref');
		}
		
		if($user->isAdmin == "Admin")
		{
			$this->parse('admin_ref', 'admin', true);
		}
		else
		{
			$this->clearVar('admin_ref');
		}
	}
}
?>