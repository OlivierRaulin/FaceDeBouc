<?php
// ---
// Nom : wall.php
// Par : Alexandre Serre
// Le : 4 decembre 2012
// Description : Test du template
// ---

require_once '../class/facedebouc.php';

Facedebouc::begin();

// Creer le template
$tpl =& new Template('wall');
Facedebouc::methodShallBe('GET');

$msgParPage=5; //Nous allons afficher 10 messages par page.
$pagesLabel = "Aucun message";

//set block
$tpl->setBlock('wall', 'wallline', 'wallline_ref');
	
if(isset($_GET['id'])) // Si la variable $_GET['id'] existe...
{
    $currentUser=intval($_GET['id']);
}
else // Sinon
{
	$currentUser=0;  
	Facedebouc::errorMessage("Erreur, utilisateur inexistant"); // Si pas d'ID dans l'URL, ce n'est pas normal : redirection.
	header('Location:/listedesutilisateurs');
	die();
}

$requete_prepare_1=$_DB->getConnexion()->prepare('SELECT count(*) as nbre, nom, prenom FROM User WHERE id_user = :id'); // on prépare notre requête
$requete_prepare_1->execute(array( 'id' => $currentUser ));
$userInfo=$requete_prepare_1->fetch(PDO::FETCH_OBJ);

if($userInfo->nbre == 0)
{
	$currentUser=0;  
    Facedebouc::errorMessage("Erreur, utilisateur inexistant"); // Si pas d'ID dans l'URL, ce n'est pas normal : redirection.
    header('Location:/listedesutilisateurs');
    die();
}

$tpl->setVar('prenom', $userInfo->prenom);
$tpl->setVar('nom', $userInfo->nom);

$retour_total=$_DB->getConnexion()->prepare('SELECT COUNT(*) AS total FROM Post WHERE userId = :id'); // nombre d'utilisateurs
$retour_total->execute(array( 'id' => $currentUser ));
$total = $retour_total->fetchColumn();

if($total != 0)
{
	//Nous allons maintenant compter le nombre de pages.
	$nombreDePages=ceil($total/$msgParPage);
	
	if(isset($_GET['page'])) // Si la variable $_GET['page'] existe...
	{
	     $pageActuelle=intval($_GET['page']);
	     
	     if($pageActuelle>$nombreDePages) // Si la valeur de $pageActuelle (le numéro de la page) est plus grande que $nombreDePages...
	     {
	          $pageActuelle=$nombreDePages;
	     }
	}
	else // Sinon
	{
	     $pageActuelle=1; // La page actuelle est la n°1    
	}
	
	$premiereEntree=($pageActuelle-1)*$msgParPage; // On calcul la première entrée à lire
	
	//display users 
	$msg=$_DB->getConnexion()->prepare("SELECT date, message, hasImage, hasMessage, Image FROM Post WHERE userId = :id ORDER BY id_post DESC LIMIT ".$premiereEntree.", ".$msgParPage."");
	$msg->execute(array( 'id' => $currentUser ));
	$msg->setFetchMode(PDO::FETCH_OBJ);
	
	$tpl->setVar('nbre', $total);
	$compter = 0;
	
	while($row = $msg->fetch()) // On lit les entrées une à une grâce à une boucle
	{
		$compter++;
		// TODO : propre :-D
		if($row->hasImage === "true")
		{
			$tpl->setVar('message', "<img src='/uploads/".$row->Image."' />");
		}
		elseif($row->hasMessage === "true")
		{
			$tpl->setVar('message', $row->message);
		}
	
	    
	    //$tpl->setVar('Num', $pageActuelle*$usersParPage+$compter-$usersParPage);
	    
	    $tpl->setVar('date', $row->date);
	    $tpl->parse('wallline_ref', 'wallline', true);
	}
	
	
	$pagesLabel = "";
	for($i=1; $i<=$nombreDePages; $i++) //On fait notre boucle
	{
	     //On va faire notre condition
	     if($i==$pageActuelle) //Si il s'agit de la page actuelle...
	     {
	         $pagesLabel = $pagesLabel.' [ '.$i.' ] '; 
	     }	
	     else //Sinon...
	     {
	          $pagesLabel = $pagesLabel.' <a href="/mur-'.$currentUser.'/'.$i.'/">'.$i.'</a> ';
	     }
	}
	$msg->closeCursor(); // on ferme le curseur des résultats
}

$tpl->setVar('pagesLabel', $pagesLabel);

$tpl->setBlock('wall', 'hiMsg', 'hiMsg_ref');
// Peut être qu'il n'est pas utile de mettre deux conditions à la suite mais je préfère en cas d'erreur (Alexandre)
// Si l'utilisateur est connecté
if($_USER->isLogged)
{
	// Si l'utilisateur est sur son wall
	if($_USER->id == $_GET['id'])
	{
		// Afficher le bloc pour écrire quelque chose sur son mur
		$tpl->parse('hiMsg_ref', 'hiMsg', true);
	}
	else
	{
		// Sinon ne pas afficher le bloc
		$tpl->clearVar('hiMsg_ref') ;
	}
}
else
{
	// Sinon ne pas afficher le bloc
	$tpl->clearVar('hiMsg_ref') ;
}

// Afficher le rendu du template
$tpl->draw();
?>
