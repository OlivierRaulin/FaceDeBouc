<?php
require_once '../class/facedebouc.php';
Facedebouc::begin();
Facedebouc::methodShallBe('POST');
 
$username = addslashes(strip_tags($_POST['username']));
$password = addslashes(strip_tags($_POST['password']));

// Test timer
if(!Timer::askForRequest())
{
	Facedebouc::errorMessage('Trop de tentatives. Merci d\'attendre ' . Timer::timeBeforeNextAttempt() . ' avant d\'essayer à nouveau.');
    header('Location: /enregistrement') ;
    die();
}

if(empty($username) || empty($password))
{
	Facedebouc::errorMessage("Champs non remplis");
	// Redirection
	header( 'Location: /' ) ;
	die();
}

if($_USER->logIn($username, $password))
{
	Facedebouc::errorMessage("Bienvenue parmi nous " . $_USER->fullname);
	Timer::reset();
	// Redirection
	header( 'Location: /' ) ;
	die();
}
else
{
	Facedebouc::errorMessage("Mauvaise authentification");
	// Redirection
	header( 'Location: /' ) ;
	die();
}
 
?>
