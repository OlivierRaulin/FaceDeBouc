<?php
// ---
// Nom : postermessage.php
// Par : Nicolas Montfort
// Le : 16 decembre 2012
// Description : postermessage procédure de réponse
// ---
// Modif Olivier le 17 décembre
// Rajout de sécurisation des variables POST (Failles XSS, injection, etc)

require_once '../class/facedebouc.php';
require_once '../class/bdd.php';

Facedebouc::begin();
Facedebouc::methodShallBe('POST');

if(!($_USER->isLogged == 1))
{
	Facedebouc::errorMessage("Veuillez vous authentifier");	// Redirection
	header( 'Location: /' ) ;
	die();
}

// Test timer
if(!Timer::askForRequest())
{
	Facedebouc::errorMessage('Trop de tentatives. Merci d\'attendre ' . Timer::timeBeforeNextAttempt() . ' avant d\'essayer à nouveau.');
	header( 'Location: /mur-' . $_USER->id ) ;
    die();
}

$today = date("d/m/Y");
$content = htmlspecialchars($_POST['contentPost']);
$content = trim($content); // Supprime les espaces avant et après
//$content = str_replace("'", "\'", $content); // Cette ligne est inutile (le prepare gère les injonctions : testez et vous verrez)
//$picture = htmlentities($_POST['filePost']);
$userId = $_USER->id;

if(empty($content))
{
	Facedebouc::errorMessage("Le message ne peut pas être vide !");
	header( 'Location: /mur-' . $_USER->id ) ;
	die();
}

// Vérifier la taille des champs avant d'insert en Bdd
if(strlen($content) > 140)
{
	Facedebouc::errorMessage("Le message que vous voulez poster est trop long ! 140 caractères maximum !");
	header( 'Location: /mur-' . $_USER->id ) ;
	die();
}

// Avec les prepares, on ne peut pas faire de requete SQL
// Axel : AHAH !
$requete_prepare_1 = $_DB->getConnexion()->prepare("INSERT INTO Post (userId, hasMessage, message, date) VALUES (:userId, :hasMessage, :content, :today)");
$requete_prepare_1->execute(array( 'userId' => $userId, 'hasMessage' => 'true', 'content' => $content, 'today' => $today));

Timer::reset();

// Redirection
header( 'Location: /mur-' . $_USER->id ) ;

?>
