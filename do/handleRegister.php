<?php

require_once("../class/facedebouc.php");

Facedebouc::begin();
Facedebouc::methodShallBe('POST');

// check if fields exists
if( isset($_POST['firstName']) == false ||
	isset($_POST['lastName']) == false ||
	isset($_POST['email']) == false ||
	isset($_POST['password']) == false ||
	isset($_POST['confirmPassword']) == false 
	)
{	
    header('Location: /enregistrement') ;
	die();
}


// Get POST fields
$firstName 				= addslashes(strip_tags($_POST['firstName']));
$lastName				= addslashes(strip_tags($_POST['lastName']));
$email     				= addslashes(strip_tags($_POST['email']));
$password 				= addslashes(strip_tags($_POST['password']));
$confirmPassword 		= addslashes(strip_tags($_POST['confirmPassword']));
$captcha				= addslashes(strip_tags($_POST['captcha']));


// Test timer
if(!Timer::askForRequest())
{
	Facedebouc::errorMessage('Trop de tentatives. Merci d\'attendre ' . Timer::timeBeforeNextAttempt() . ' avant d\'essayer à nouveau.');
    header('Location: /enregistrement') ;
    die();
}

// Test captcha
$captchaOK = 
	isset($_POST['captcha']) && 
	is_string($_POST['captcha']) && 
	isset($_SESSION['answer']) &&
	strlen($_POST['captcha']) > 0 && 
	strlen($_SESSION['answer']) > 0 &&
	$_POST['captcha'] == $_SESSION['answer']
;
if(! $captchaOK) 
{    	
        Facedebouc::errorMessage('Tu est un robot ? Ou tu ne sais pas remplir un captcha ?');
        header('Location: /enregistrement') ;
        die();
}

// test si les champs sont vides ou non
if(empty($firstName) || empty($lastName) || empty($email) || empty($password))
{
	Facedebouc::errorMessage("Tous les champs doivent être renseignés !");
	header('Location: /enregistrement') ;
	die();
}

// Test if email used
if($_USER->isEmailUsed($email))
{
	Facedebouc::errorMessage("Email déjà utilisé");
	header('Location: /enregistrement') ;
	die();
}

// Vérifier le format de l'adresse email
if(!(Facedebouc::VerifierAdresseMail($email))){  
    Facedebouc::errorMessage("L'adresse e-mail que vous venez de saisir n'est pas au bon format !");
	header('Location: /enregistrement') ;
	die();
}

// test password confirmation
if(! ($password === $confirmPassword))
{
	Facedebouc::errorMessage("La confirmation du mot de passe n'est pas identique au mot de passe");
	header('Location: /enregistrement') ;
	die();
}

// Vérifier la taille des champs avant d'insert en Bdd
if(strlen($firstName) > 50  || strlen($lastName) > 50 || strlen($email) > 50 || strlen($password) > 50)
{
	Facedebouc::errorMessage("La taille des champs que vous avez renseigné est incorrecte !");
	header('Location: /enregistrement') ;
	die();
}

if($_USER->insert($lastName, $firstName, $password, $email))
{
	Facedebouc::errorMessage("Compte créé avec succès, bienvenue dans le monde des gens qui ont un problème dans leur tête !");
	Timer::reset();
	header( 'Location: /mur-' . $_USER->id );
	die();
}
else
{
	Facedebouc::errorMessage("Impossible de créer ce compte");
	header('Location: /enregistrement') ;
	die();
}
?>
