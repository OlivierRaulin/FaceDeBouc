<?php
/* ---
* Nom : postimage.php
* Par : Olivier RAULIN
* Le : 17 decembre 2012
* Description : Traitement des images uploadées
* Données en entrée :
* POST :
*	* postImage
* Données en sortie
* 	Rien
* Traitements effectués
* 	* check extension du fichier
* 	* check le type MIME
* 	* checke la taille
* 	* Regarde le début du fichier (Je ne sais pas faire)
* ---
*/
require_once '../class/facedebouc.php';
require_once '../class/bdd.php';

Facedebouc::begin();
Facedebouc::methodShallBe('POST');

$extension = NULL;
global $_USER;

// Test timer
if(!Timer::askForRequest())
{
	Facedebouc::errorMessage('Trop de tentatives. Merci d\'attendre ' . Timer::timeBeforeNextAttempt() . ' avant d\'essayer à nouveau.');
	header("Location:/mur-".$_USER->id."/1/");
    die();
}

// Desactivated, but works
/*if(! checkDiskSpace())
{
	Facedebouc::errorMessage('Il n\'y a plus de place sur le disque dur du serveur, désolé.');
	header("Location:/mur-".$_USER->id."/1/");
    die();
}*/

if(isset($_FILES['postImage']) && !empty($_FILES['postImage']) && $_USER->isLogged)
{
	$fichier = $_FILES['postImage']['tmp_name'];
	
	if(checkExtension($fichier) && checkMIME($fichier) && checkSize($fichier) && lookBeginFichier($fichier)) 
	{
		process($fichier);
		Timer::reset();
	}
	else 
	{
		Facedebouc::errorMessage( "Fichier non conforme (JPG, PNG) entre 40ko et 1Mo");
		header("Location:/mur-".$_USER->id."/1/");
		die();
	}
}
else 
{
	Facedebouc::errorMessage( "Tu as oublié d'envoyer ton fichier et/ou de te connecter :)");
	header('Location:/');
	die();
}

function checkExtension()
{

	global $extension;
	$file = $_FILES['postImage']['name'];
	$extension=strrchr($file,'.');
	$extension=substr($extension,1) ;
	return($extension === 'jpg' || $extension ==='JPG' || $extension === 'jpeg' || $extension ==='JPEG' || $extension === 'png' || $extension === 'PNG' /* || $extension === 'gif' || $extension === 'GIF' */);
}

function checkMIME($fichier)
{

	$file =	$_FILES['postImage']['type'];
	$finfo = finfo_open(FILEINFO_MIME_TYPE);
	$file2 = finfo_file($finfo, $fichier); // This read the magic bytes !
	
	return (($file === 'image/jpeg' || $file === 'image/png' /*|| $file === 'image/gif'*/) && ($file2 === 'image/jpeg' || $file2 === 'image/png' /*|| $file2 === 'image/gif'*/));
}

function checkSize($file)
{
	return filesize($file) < 1024000 && filesize($file) > 40000;
}

function lookBeginFichier($file)
{
	// done in chexkMime
	return true;
}

function process($file)
{
	global $extension;
	global $_USER;
	$uploadFolder = $_SERVER["DOCUMENT_ROOT"]."/uploads/"; 
	$newName = md5(microtime()).".".$extension;
	
	if($extension === 'jpg' || $extension === 'JPG' || $extension === 'jpeg' || $extension ==='JPEG' )
	{
		$source = ImageCreateFromJpeg($file);
	}
	else if($extension === 'png' || $extension === 'PNG')
	{
		$source = ImageCreateFromPng($file);
	}
	/*else if($extension === 'gif' || $extension === 'GIF') 
	{
		if(move_uploaded_file($file, $uploadFolder.$newName))
		{
			$userId = $_USER->id;
	        $today = date("d/m/Y");
	        $connexion = new Bdd();  
	        
			$requete_prepare_1 = $connexion->getConnexion()->prepare("INSERT INTO Post (userId, hasImage, Image, date) VALUES (:userId, :bool, :newName, :date)");
			$requete_prepare_1->execute(array( 'userId' => $userId, 'bool' => 'true', 'newName' => $newName, 'date' => $today));
		}
		else
		{
			Facedebouc::errorMessage("Erreur interne au traitement de l'image, désolé ;-)");
	    	header("Location:/mur-".$_USER->id);
	    	die();	
		}
	}*/
	else
	{
		Facedebouc::errorMessage("Erreur sur le format du fichier");
		header("Location:/mur-".$_USER->id);
    	die();
	}

	if(isset($source))
	{
		$hauteur = imagesx($source); // En fait c'est la largeur
        $largeur = imagesy($source); // Et ici la hauteur
        if($hauteur > 800)
        {
		    $ratio = $largeur / $hauteur;
		    $largeurdest = 800;
		    $hauteurdest = $largeurdest * $ratio;
        }
        else
        {
        	$largeurdest = $hauteur - 1;
        	$hauteurdest = $largeur - 1;
        }
        
        $destination = imagecreatetruecolor($largeurdest, $hauteurdest);
        $copied = false;
        if(!ImageCopyResampled($destination, $source, 0, 0, 0, 0, $largeurdest, $hauteurdest, $hauteur, $largeur))
        {
        	Facedebouc::errorMessage("Erreur de redimensionnement");
        }
        if($extension === 'jpg' || $extension === 'JPG' || $extension === 'jpeg' || $extension ==='JPEG')
        {
        	$copied = imagejpeg($destination, $uploadFolder.$newName);
        }
        else if($extension === 'png' || $extension === 'PNG')
        {
        	$copied = imagepng($destination, $uploadFolder.$newName);
        }
        else 
        {
        	Facedebouc::errorMessage("Erreur d'extension");
        	header("Location:/mur-".$_USER->id);
    		die();
        }
        
        if($copied)
        {
		    $userId = $_USER->id;
		    $today = date("d/m/Y");
		    $connexion = new Bdd();
			
			$requete_prepare_2 = $connexion->getConnexion()->prepare("INSERT INTO Post (userId, hasImage, Image, date) VALUES (:userId, :hasImage, :newName, :today)");
			$requete_prepare_2->execute(array( 'userId' => $userId, 'hasImage' => 'true', 'newName' => $newName, 'today' => $today));
		}
		else
		{
	    	Facedebouc::errorMessage("Fichier non conforme (JPG, PNG) entre 40ko et 1Mo");
	    	header("Location:/mur-".$_USER->id);
	    	die();	
		}
    }
    else
    {
    	Facedebouc::errorMessage("Fichier non conforme (JPG, PNG) entre 40ko et 1Mo");
    	header("Location:/mur-".$_USER->id);
    	die();
    }
    header("Location:/mur-".$_USER->id);
    die();
}

function checkDiskSpace()
{
	$uploadFolder = $_SERVER["DOCUMENT_ROOT"]."/uploads/";
	return disk_free_space($uploadFolder) > 1000000000; // 1Go
}

?>
