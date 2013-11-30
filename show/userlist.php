<?php
// ---
// Nom : userlist.php
// Par : Alexandre Serre
// Le : 4 decembre 2012
// Description : 
// ---

require_once '../class/facedebouc.php';

Facedebouc::begin();
Facedebouc::methodShallBe('GET');

// Creer le template
$tpl = new Template('userlist');

$usersParPage=100; //Nous allons afficher 100 uers par page.

$retour_total=$_DB->getConnexion()->query('SELECT COUNT(*) AS total FROM User'); // nombre d'utilisateurs
$total = $retour_total->fetchColumn();

//Nous allons maintenant compter le nombre de pages.
$nombreDePages=ceil($total/$usersParPage);

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

$premiereEntree=($pageActuelle-1)*$usersParPage; // On calcul la première entrée à lire

//set block
$tpl->setBlock('userlist', 'userlistline', 'userlistline_ref');
$tpl->setVar('nbre', $total);
$compter = 0;

//display users 
if($total != 0)
{
	$users=$_DB->getConnexion()->query("SELECT nom, prenom, id_user FROM User ORDER BY prenom, nom LIMIT ".$premiereEntree.", ".$usersParPage."");
	$users->setFetchMode(PDO::FETCH_OBJ);

	while($row = $users->fetch()) // On lit les entrées une à une grâce à une boucle
	{
	    $compter ++;
	    $numero = $pageActuelle*$usersParPage+$compter-$usersParPage;
	    $tpl->setVar('userList', '<tr><th><a href="/mur-'.$row->id_user.'/1/">'.$numero.'</a></th><td><a href="/mur-'.$row->id_user.'/1/">'.$row->prenom.'</a></td><td><a href="/mur-'.$row->id_user.'/1/">'.$row->nom.'</a></td></tr>');
	    $tpl->parse('userlistline_ref', 'userlistline', true);
	    
	}

	$users->closeCursor(); // on ferme le curseur des résultats
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
          $pagesLabel = $pagesLabel.' <a href="listedesutilisateurs-'.$i.'">'.$i.'</a> ';
     }
}
$tpl->setVar('pagesLabel', $pagesLabel);

// Afficher le rendu du template
$tpl->draw();
?>