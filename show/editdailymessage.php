<?php
// ---
// Nom : editdailymessage.php
// Par : Alexandre Serre
// Le : 15 decembre 2012
// Description : EditDailyMessage procédure d'affichage
// ---

require_once '../class/facedebouc.php';
require_once '../class/bdd.php';

Facedebouc::begin();
Facedebouc::methodShallBe('GET');

if(!($_USER->isLogged == 1 && $_USER->isAdmin == "Admin"))
{
	Facedebouc::errorMessage("Non autorisé");	// Redirection
	header( 'Location: /' ) ;
	die();
}

// Create template
$tpl =& new Template('editdailymessage');

$connexion = new Bdd(); 

$retour_total=$connexion->getConnexion()->query('SELECT COUNT(*) AS total FROM DailyMessage'); // nombre d'utilisateurs
$total = $retour_total->fetchColumn();

$dailyMessage=$connexion->getConnexion()->query("SELECT text, date_dailyMessage, title FROM DailyMessage ORDER BY id_dailyMessage ASC"); 
$dailyMessage->setFetchMode(PDO::FETCH_OBJ);

//set block
$tpl->setBlock('editdailymessage', 'dailymessagelist', 'dailymessagelist_ref');

// Display DailyMessage number
$tpl->setVar('nbre', $total);

// Display all DailyMessage
while( $row = $dailyMessage->fetch() ) // on récupère la liste des membres
{
	$tpl->setVar('Date', $row->date_dailyMessage);
    $tpl->setVar('Message', $row->text);
    $tpl->setVar('Titre', $row->title);
	$tpl->parse('dailymessagelist_ref', 'dailymessagelist', true);
}

$dailyMessage->closeCursor();

// Display template
$tpl->draw();
?>
