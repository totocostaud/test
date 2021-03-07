<?php
/**
 * File : unionpresse.fr/sites/all/eudonet_api/data_format.php
 */
?>

<?php 
// error_reporting(E_ALL);
// ini_set('display_errors','1');

// Traitement de la variable 'nom' avant enregistrement en BDD (et non tableau de pls variables) 
// function format($tab) {
function format($value) {
	
  // foreach ($tab as $key => $value) {
	  
	       // suppression des caractères accentués et apostrophes pour Eudonet
	       $bad = array(
			       "à",
			       "â",
			       "ä",
			       "é",
			       "è",
			       "ê",
			       "ë",
			       "û",
			       "ü",
			       "ù",
			       "î",
			       "ï",
			       "ô",
			       "ö",
			       "'", // apostrophe
	       );

	       $good = array(
			       "a",
			       "a",
			       "a",
			       "e",
			       "e",
			       "e",
			       "e",
			       "u",
			       "u",
	           "u",
			       "i",
			       "i",
			       "o",
		         "o",
			       " ",  // pour l'apostrophe
	       );

	       // $data[$key] = strip_tags ( addslashes ( strtoupper ( str_ireplace( $bad, $good, $value ) )));
	       $data = strip_tags ( addslashes ( strtoupper ( str_ireplace( $bad, $good, $value ) ))); 
  // }

  return $data;
}
