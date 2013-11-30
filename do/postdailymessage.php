<?php
// ---
// Nom : postdailymessage.php
// Par : Nicolas Montfort
// Le : 16 decembre 2012
// Description : postdailymessage procédure de réponse
// ---
// Modif par Olivier le 17 décembre : rajout de htmlentities pour sécurité

require_once '../class/facedebouc.php';
require_once '../class/bdd.php';

Facedebouc::begin();
Facedebouc::methodShallBe('POST');

if(!($_USER->isLogged == 1 && $_USER->isAdmin == "Admin"))
{
	Facedebouc::errorMessage("Non autorisé");	// Redirection
	header( 'Location: /' ) ;
	die();
}

// Test timer
if(!Timer::askForRequest())
{
	Facedebouc::errorMessage('Trop de tentatives. Merci d\'attendre ' . Timer::timeBeforeNextAttempt() . ' avant d\'essayer à nouveau.');
    header('Location: /editermessagedujour') ;
    die();
}

$today = date("d.m.Y-H:i:s");
$title = htmlspecialchars($_POST['dailyMessageTitle']);
$text = htmlspecialchars($_POST['dailyMessageText']);

// Trim() supprime les caractères invisibles en début et fin de chaîne.
$title = trim($title);
$text = trim($text);

// Vérifier la taille des champs avant d'insert en Bdd
if(strlen($text) > 200  || strlen($title) > 30)
{
	Facedebouc::errorMessage("La taille des champs que vous avez renseigné est incorrecte !");
	header('Location: /editermessagedujour') ;
	die();
}

// TODO : vérifier si le $text == NULL est utile !
if (!empty($text) && !empty($title))
{
	$connexion = new Bdd();
	$requete_prepare_1 = $connexion->getConnexion()->prepare("INSERT INTO DailyMessage (date_dailyMessage, text, title) VALUES (:today, :text, :title)");
	$requete_prepare_1->execute(array( 'today' => $today, 'text' => $text, 'title' => $title));
	Facedebouc::errorMessage("Message du jour mis à jour");
	Timer::reset();
}
else
{
	Facedebouc::errorMessage("Le titre et le message ne peuvent pas être vides !");
	header( 'Location: /editermessagedujour' );
	die();
}

// Redirection
header( 'Location: /editermessagedujour' ) ;
?>

