<?php

require_once("../class/facedebouc.php");
Facedebouc::begin();
Facedebouc::methodShallBe('POST');


// test when the POST var aren't present
if( isset($_POST['firstName']) == false ||
	isset($_POST['lastName']) == false ||
	isset($_POST['email']) == false ||
	isset($_POST['oldpassword']) == false ||
	isset($_POST['password']) == false ||
	isset($_POST['confirmPassword']) == false
	)
{	
	header( 'Location: /editermonprofil' );
	die();
}

// Get POST fields
// TODO: add addslashed etc ....
$firstName 			= addslashes(strip_tags($_POST['firstName']));
$lastName			= addslashes(strip_tags($_POST['lastName']));
$email     			= addslashes(strip_tags($_POST['email']));
$oldpassword		= addslashes(strip_tags($_POST['oldpassword']));
$password 			= addslashes(strip_tags($_POST['password']));
$confirmPassword 	= addslashes(strip_tags($_POST['confirmPassword']));


// Test timer
if(!Timer::askForRequest())
{
	Facedebouc::errorMessage('Trop de tentatives. Merci d\'attendre ' . Timer::timeBeforeNextAttempt() . ' avant d\'essayer à nouveau.');
    header('Location: /editermonprofil') ;
    die();
}

// test si les champs sont vides ou non
if(empty($firstName) || empty($lastName) || empty($email) || empty($oldpassword))
{
	Facedebouc::errorMessage("Tous les champs marqués d'une étoile doivent être renseignés !");
	header('Location: /editermonprofil') ;
	die();
}

// Vérifier le format de l'adresse email
if(!(Facedebouc::VerifierAdresseMail($email)))
{  
    Facedebouc::errorMessage("L'adresse e-mail que vous venez de saisir n'est pas au bon format !");
	header('Location: /editermonprofil') ;
	die();
}

// Test if email used
if($_USER->email != $email && $_USER->isEmailUsed($email))
{
	Facedebouc::errorMessage("Email déjà utilisé");
	header( 'Location: /editermonprofil' );
	die();
}

// test si l'ancien mot de passe est correct
if(!(Pbkdf2::validate_password($oldpassword, $_USER->password)))
{
	Facedebouc::errorMessage("Le mot de passe que vous venez de saisir est incorrect !");
	header('Location: /editermonprofil') ;
	die();
}

// this could be done in User::update
if(! ($password === $confirmPassword))
{
	Facedebouc::errorMessage("La confirmation du mot de passe n'est pas identique au mot de passe.");
	header( 'Location: /editermonprofil' );
	die();
}

// Vérifier la taille des champs avant d'upload en Bdd
if(strlen($firstName) > 50  || strlen($lastName) > 50 || strlen($email) > 50 || strlen($password) > 50 || strlen($oldpassword) > 50)
{
	Facedebouc::errorMessage("La taille des champs que vous avez renseigné est incorrecte !");
	header('Location: /editermonprofil') ;
	die();
}

if(empty($password))
{
	if($_USER->updateWithoutPassword($lastName, $firstName, $email))
	{
		Facedebouc::errorMessage("Profil mis à jour."); 
		Timer::reset();
		header( 'Location: /mur-' . $_USER->id );
		die();
	}
	else
	{
		Facedebouc::errorMessage("Une erreur est survenue, ahah !"); 
		header( 'Location: /editermonprofil' ) ;
		die();
	}
}
else
{
	if($_USER->update($lastName, $firstName, $password, $email))
	{
		Facedebouc::errorMessage("Profil mis à jour."); 
		Timer::reset();
		header( 'Location: /mur-' . $_USER->id );
		die();
	}
	else
	{
		Facedebouc::errorMessage("Une erreur est survenue, ahah !"); 
		header( 'Location: /editermonprofil' ) ;
		die();
	}
}


?>
