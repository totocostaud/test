<?php

/**
 * Link with the Eudonet API (logic part only)
 *
 * We have a name and a nim coming from the refusal form for La Tribune
 *
 * 1 - We are searching in Eudonet from those 2 items in the table 300 (= SOCIETES),
 * adding 2 more conditions in this table = Fermer = non and Archivé = non
 * and adding 2 other conditions in the table 400 (ADRESSE) = active = oui + principale = oui
 * We're requesting for ppid, the name and the field 'attitude_tribune' in the same time (param listCols)
 *
 * If an error is returned, the change in the error flag stops the form validation
 * and give an explanation message which will be displayed by the custom modules .module file
 *
 **/

require_once ( DRUPAL_ROOT . '/eudonet_api/connexion_api.php');

// Reset of the error flag
$error = '';
global $pp_id, $attitude_tribune; // we need global for up_refusal updating in Eudonet

// formating the submitted name (no accent, no apostrophe, uppercase) to retreive it in Eudonet
require_once ( DRUPAL_ROOT . '/eudonet_api/data_format.php');
$submitted_name = format($nom);

// Search from the given NIM. If it's found in the database, we have a PM ID to go further
$result_data = array(); // initialisation
$result_data = get_data($nim);
// var_dump($result_data); die();

// if there's a result (and only one), we can now check the given name with the name in the database
if (isset($result_data['success']) && $result_data['success'] != 0) {
  $nom = $result_data['success']['nom'];
  $attitude_tribune = $result_data['success']['attitude_tribune'];
  $pp_id = $result_data['success']['pp_id'];

  if ($submitted_name != $nom) {
    $error = 'no match with name';
  }
}
else
{ // this nim isn't in the database or is more than once
  if (isset($result_data['error']) && $result_data['error'] == 'nim is not unique') {
    $error = 'nim is not unique';
  } elseif (isset($result_data['error']) && $result_data['error'] == 'nim unknown') {
    $error = 'nim unknown';
  }
}

// Deconnecting. Nota : if the call comes from up_refusal, the update has been done.
require_once ( DRUPAL_ROOT . '/eudonet_api/deconnexion_api.php');
// session_unset();
// session_destroy();


/**
 * Custom function
 * Retreiving an ID on SOCIETES table (PM) for the submitted NIM
 *
 * @param $nim
 * The submitted nim number
 * @return $result_pm_id
 * Array of results with 2 possibles keys : success or error
 */
function get_data($nim) {
  require_once ( DRUPAL_ROOT . '/eudonet_api/attitude_tribune/2_search_from_nim_nom.php');
  return $result_data;
}

?>

