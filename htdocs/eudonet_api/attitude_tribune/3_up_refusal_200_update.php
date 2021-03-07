<?php
/**
 * File : dev.expopresse/htdocs/sites//all/eudonet_api/unionpresse/attitude_up/up_refusal_200_update.php
 *
 * 4th step in the process of up_refusal webform data
 * Updating field 218 'Attitude UP'
 * Updating field 219 'Date'
 * Updating field 224 'Nature refus'
 *
 * Documentation for cURL POST request
 * https://stackoverflow.com/questions/37634033/how-to-create-a-curl-post-request-in-php
 *
 * Method : POST /CUD/{tabId}/{fileId}
 */

// error_reporting(E_ALL);
// ini_set('display_errors','1');

$tabId = 200;
$url = $_SESSION['eudonet_base_url'] . '/CUD/' . $tabId . '/' . $pp_id;

$today = date('Y/m/d H:i:s'); // Eudonet DATETIME format
// var_dump($today);  die;

$request = array(
  "Fields" => array (
    0 =>  array(
      "DescId" => 243,
      "Value" => "3480",
    ),
    1 => array(
      "DescId" => 246,
      "Value" => $today,
    ),
    2 => array(
      "DescId" => 247,
      "Value" => "3479",
    ),
  ),
);

$data = json_encode($request);

$curl_handle = curl_init();

// Putting the token an informing about the json request in the headers
$headers = array(
  'x-auth: ' . $_SESSION['token'],
  'Accept: application/json',
  'Content-type: application/json',
);

curl_setopt($curl_handle, CURLOPT_URL, $url);
curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($curl_handle, CURLOPT_POST, true);
curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $data);
curl_setopt($curl_handle, CURLOPT_HTTPHEADER, $headers);
// curl_setopt($curl_handle, CURLINFO_HEADER_OUT, true); // if needed (debug) to see header lines which have been sent
curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);  // TRUE return a string and not a direct display on screen

$curl_response = curl_exec($curl_handle);

if ($curl_response === false) {
  $info = curl_getinfo($curl_handle);
  curl_close($curl_handle);
  die('error occurred during curl exec. Additional info: ' . var_dump($info));
}

curl_close($curl_handle);


// if we have a response...
$decoded_response = json_decode($curl_response, true);
// var_dump($decoded_response);   die();

if (isset($decoded_response->$curl_response->status) && $decoded_response->$curl_response->status == 'ERROR') {
  die('error occurred: ' . $decoded_response->$curl_response->errormessage);
}

if ($decoded_response['ResultInfos']['ApiMessage'] == "Insertion/mise à jour effectuée."
  && !empty(['ResultData'])) {
    $result_update['success'] = 'Insertion/mise à jour effectuée';
  } else {
    $result_update['error'] = 'Echec de la mise à jour';
  }
?>