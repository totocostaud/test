<?php

function no_accent($nom) {

	$bad = array(
			"À",
			"Â",
			"Ä",
			"É",
	        "È",
	        "Ê",
			"Ë",
			"Û",
			"Ü",
			"Î",
			"Ï",
			"Ô",
			"Ö",
	        "Ç",
			"'", // apostrophe
	);

	$good = array(
			"A",
			"A",
			"A",
			"E",
			"E",
			"E",
			"E",
			"U",
			"U",
			"I",
			"I",
			"O",
			"O",
	        "C",
			" ",  // pour l'apostrophe
	);

	// $nom_ok = strip_tags ( addslashes ( strtoupper ( str_ireplace( $bad, $good, $nom ) )));
    $nom_ok = strip_tags ( addslashes ( str_ireplace( $bad, $good, $nom ) ));

	return $nom_ok;
}