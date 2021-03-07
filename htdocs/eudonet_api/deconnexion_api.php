<?php
/**
 * Connecting to EudoAPI/
 *
 * Method : POST /Authenticate/Token
 * Documentation : http://xrm3.eudonet.com/eudoapi/eudoapidoc/swaggerui/
 **/

$_SESSION['eudonet_base_url'] = 'http://xrm3.eudonet.com/EudoAPI';

$url = 'https://xrm3.eudonet.com/EudoAPI/Authenticate/Token';

// getting and opening the json file containing the credentials
$credentials_url = DRUPAL_ROOT . '/eudonet_api/authentication.json';
$data = file_get_contents($credentials_url);

$curl_handle = curl_init();
curl_setopt($curl_handle, CURLOPT_URL, $url);
curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($curl_handle, CURLOPT_POST, true);
curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $data);
curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true); // true = retour ss forme de chaîne et non affichage direct

$curl_response = curl_exec($curl_handle);

if ($curl_response === false) {
  $info = curl_getinfo($curl_handle);
  curl_close($curl_handle);
  die('error occurred during curl exec. Additional info: ' . var_dump($info));
}

curl_close($curl_handle);

// if we have a response...
 $json   = json_decode($curl_response);

 if (isset($decoded->$curl_response->status) && $decoded->$curl_response->status == 'ERROR') {
   die('error occurred: ' . $decoded->$curl_response->errormessage);
 }

 $token = $json->ResultData->Token;
 $_SESSION['token'] = $token;
?>
