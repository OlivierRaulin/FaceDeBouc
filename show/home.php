<?php
// ---
// Nom : home.php
// Par : Axel Guilmin
// Le : 1er decembre 2012
// Description : Demonstration du moteur de template

// Par : Alexandre Serre
// Le : 4 decembre 2012
// Description : Modification du home.php pour l'affichage des articles
// ---

require_once '../class/facedebouc.php';
require_once '../class/bdd.php';

Facedebouc::begin();
Facedebouc::methodShallBe('GET');

// Creer le template
$tpl =& new Template('home');

$connexion = new Bdd(); 

$lastDailyMessage=$connexion->getConnexion()->query("SELECT title, text FROM DailyMessage ORDER BY id_dailyMessage DESC LIMIT 0,1");
$lastDailyMessage->setFetchMode(PDO::FETCH_OBJ);

while( $rowDaily = $lastDailyMessage->fetch() ) 
{
	$tpl->setVar('LastDailyMessageTitle',$rowDaily->title);
	$tpl->setVar('LastDailyMessage',$rowDaily->text);
}

$allPost=$connexion->getConnexion()->query("SELECT title, text FROM DailyMessage ORDER BY id_dailyMessage DESC LIMIT 1,3"); 
$allPost->setFetchMode(PDO::FETCH_OBJ);

//set block
$tpl->setBlock('home', 'homeline', 'homeline_ref');
//$tpl->setVar('nbre', count($messages));

//display messages
// On limitera au nombre à 3 posts sur la page
/*
while( $row = $allPost->fetch() ) // on récupère la liste des membres
{
	$tpl->setVar('title', $row->title);
    $tpl->setVar('text', $row->text);
	$tpl->parse('homeline_ref', 'homeline', true);
}*/


// "SELECT count(*) FROM Table_Message"
/*if(count($messages) > 3)
{
    $tpl->setVar('suivant', 'More articles' );
}
else
{
    $tpl->setVar('suivant', '');
}*/

// Afficher le rendu du template
$tpl->draw();
?>
