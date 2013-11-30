<?php
// ---
// Nom : error.php
// Par : Alexandre Serre
// Le : 4 decembre 2012
// Description :
// ---

require_once '../class/facedebouc.php';
Facedebouc::begin();
Facedebouc::methodShallBe('GET');

// Creer le template
$tpl =& new Template('erreur');

$tpl->setVar('errorNumber', addslashes($_GET['id']));

// Afficher le rendu du template
$tpl->draw();
?>
