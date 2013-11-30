<?php
// ---
// Nom : register.php
// Par : Alexandre Serre
// Le : 4 decembre 2012
// Description : Quand l'utilisateur voudra voir l'article en entier
// ---

require_once '../class/facedebouc.php';

Facedebouc::begin();
Facedebouc::methodShallBe('GET');

if($_USER->isLogged)
{
	Facedebouc::errorMessage("Vous êtes déjà connecté avec un utilisateur !"); // Si l'utilisateur est déjà authentifié
	header('Location:/');
    die();
}

// Creer le template
$tpl =& new Template('register');

// Set CAPTCHA options (font must exist!)
$imageOptions = array(
    'font_size'        => 30,
    'font_path'        => /*'/usr/share/fonts',*/ $_SERVER["DOCUMENT_ROOT"]."/font/",
    'font_file'        => /*'arial.ttf', */ 'hackslsh.ttf',
    'text_color'       => '#333333',
    'lines_color'      => '#555555',
    'background_color' => '#f2f2f2'
);

// Set CAPTCHA options
$options = array(
    'width' => 100,
    'height' => 100,
    'output' => 'png',
    'imageOptions' => $imageOptions
);
           
// Generate a new Text_CAPTCHA object, Image driver
$c = Text_CAPTCHA::factory('Image');
$retval = $c->init($options);
if(PEAR::isError($retval)) 
{
    Facedebouc::errorMessage('Error initializing CAPTCHA.');
	header('Location:/');
    die();
}

// Get CAPTCHA secret passphrase
$_SESSION['answer'] = $c->getPhrase();

// Get CAPTCHA image (as PNG)
$png = $c->getCAPTCHAAsPNG();
if(PEAR::isError($png)) 
{
    Facedebouc::errorMessage('Error initializing CAPTCHA.');
	header('Location:/');
    die();
}


$base64 = 'data:image/' . 'png' . ';base64,' . base64_encode($png);
$tpl->setVar('captchaRaw', $base64);

// Afficher le rendu du template
$tpl->draw();
?>
