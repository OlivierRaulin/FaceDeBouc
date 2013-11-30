<?php
require_once '../class/facedebouc.php';
 
Facedebouc::begin();
Facedebouc::methodShallBe('POST');

$_USER->logOut();

Facedebouc::errorMessage("Bye.");
 
// Redirection
header( 'Location: /' ) ;
?>