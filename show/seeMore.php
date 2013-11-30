<?php
// ---
// Nom : seeMore.php
// Par : Alexandre Serre
// Le : 4 decembre 2012
// Description : Quand l'utilisateur voudra voir l'article en entier
// ---

require_once '../class/facedebouc.php';
Facedebouc::begin();

// Creer le template
$tpl =& new Template('seeMore');

$tpl->setVar('LastDailyMessageTitle','Asterix - Mission Cléopatre');
$tpl->setVar('LastDailyMessage','Vous savez, moi je ne crois pas quil y ait de bonne ou de mauvaise situation. Moi, si je devais résumer ma vie aujourdhui avec vous, je dirais que cest dabord des rencontres. Des gens qui mont tendu la main, peut-être à un moment où je ne pouvais pas, où jétais seul chez moi. Et cest assez curieux de se dire que les hasards, les rencontres forgent une destinée... Parce que quand on a le goût de la chose, quand on a le goût de la chose bien faite, le beau geste, parfois on ne trouve pas linterlocuteur en face je dirais, le miroir qui vous aide à avancer. Hors ce nest pas mon cas, comme je disais là, puisque moi au contraire, jai pu : et je dis merci à la vie, je lui dis merci, je chante la vie, je danse la vie... Je ne suis quamour ! Et finalement, quand beaucoup de gens, aujourd’hui me disent "Mais comment fais-tu pour avoir cette humanité ?", hé bien je leur réponds très simplement, je leur dis que cest ce goût de lamour, ce goût donc qui ma poussé aujourdhui à entreprendre une construction mécanique, mais demain qui sait ? Peut-être simplement à me mettre au service de la communauté, et à faire le don, le don de soi...');

// Afficher le rendu du template
$tpl->draw();
?>
