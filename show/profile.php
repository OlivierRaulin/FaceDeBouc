<?
// ---
// Nom : profile.php
// Par : Alexandre Serre
// Le : 4 decembre 2012
// Description : Test du template
// ---

require_once '../class/facedebouc.php';
Facedebouc::begin();

// Creer le template
$tpl =& new Template('profile');

$tpl->setVar('url','https://fbcdn-profile-a.akamaihd.net/hprofile-ak-prn1/c21.21.267.267/s160x160/39533_1448789384608_6595574_n.jpg');
$tpl->setVar('prenom','Alexandre');
$tpl->setVar('nom','Serre');

// we want to display this message list
// "SELECT message, image, datetime FROM Table_Message ORDER BY DESC datetime"
$messages = array(
    'Super, je vais enfin pouvoir jouer à la nouvelle WiiU !!' => 'December 4',
    'Il va faire tout noir !!' => 'December 2',
    'Cest un peu chiant. Ya personne sur FacedeBouc' => 'November 30',
    'Bon comme vous laurez compris, je nai absolument pas dinspiration !!' => 'November 14',
    'Franchement les cours a lepsi cest super !! #ironique' => 'November 13',
    'On sest un peu fait vendre par Reinold aujourdhui vous trouvez pas ?' => 'November 9',
    'Ca fait quand meme un moment que je ne suis pas retourne sur FacedeBouc. Ya quelque chose qui a changé ?' => 'November 30',
    'Amazing !! Va sy cest mon premier message sur mon mur !! FaceDeBouc ca cartonne !!' => 'Juin 12'
);

//set block
$tpl->setBlock('profile', 'profileline', 'profileline_ref');
$tpl->setVar('nbre', count($messages));

//display messages
// On limitera au nombre à 3 posts sur la page
foreach($messages as $msg => $datetime) 
{
    $tpl->setVar('message', $msg);
    $tpl->setVar('date', $datetime);
    $tpl->parse('profileline_ref', 'profileline', true);
}

// Afficher le rendu du template
$tpl->draw();
?>