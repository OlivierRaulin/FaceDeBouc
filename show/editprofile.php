<?php
// ---
// Nom : editprofile.php
// Par : Alexandre Serre
// Le : 5 decembre 2012
// Description : Test du template
// ---

require_once '../class/facedebouc.php';
Facedebouc::begin();
Facedebouc::methodShallBe('GET');

if(!($_USER->isLogged == 1))
{
	Facedebouc::errorMessage("Veuillez vous authentifier");	// Redirection
	header( 'Location: /' ) ;
	die();
}

// Creer le template
$tpl =& new Template('editprofile');

$tpl->setVar('prenom',$_USER->firstname);
$tpl->setVar('nom',$_USER->name);
$tpl->setVar('email',$_USER->email);
$tpl->setVar('dtc', $_USER->dtc);

// Afficher le rendu du template
$tpl->draw();
?>
