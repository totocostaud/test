<?php
// error_reporting(E_ALL);
// ini_set('display_errors','1');

/*global $base_url;
$tab = explode('//', $base_url);
$site = $tab[1];*/

// appel de la fonction mail pour envoi en SMTP

$to  = "cmarquaire@unionpresse.fr";
$subject = "NIM error in Eudonet";
$message = "NIM en doublon détecté dans Eudonet.<br>NIM = $nim";

$from  = "From:contact@unionpresse.fr\n";
$from .= "MIME-version: 1.0\n";
$from .= "Reply-To: contact@unionpresse.fr\n";
$from .= "Content-type: text/html; charset= UTF-8";

mail( $to , $subject, $message , $from );