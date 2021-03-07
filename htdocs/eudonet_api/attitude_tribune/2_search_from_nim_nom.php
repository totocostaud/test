<?php
/**
 * @File : /eudonet_api/get_diffuseur/2_search_nim.php
 *
 * Processing the form
 * We're searching for a nim in table 300 (SOCIETES)
 * If we have a result, we have the ID (fileId or $pm_id) in this table.
 *
 * Documentation : Examples with a json file for request (tested in Swagger UI) and file_get_contents()
 * https://www.taniarascia.com/how-to-use-json-data-with-php-or-javascript/
 *
 * Help with an online function tester
 * http://php.fnlist.com/php/json_decode
 *
 * Documentation for cURL POST request
 * https://stackoverflow.com/questions/37634033/how-to-create-a-curl-post-request-in-php
 *
 * Method : GET /Search/{tabId}
 */

// error_reporting(E_ALL);
// ini_set('display_errors','1');

$tabId = 300;
$url = $_SESSION['eudonet_base_url'] . '/Search/' . $tabId;

$request = array(
  "ShowMetadata" => true,
  "RowsPerPage" => 0,
  "NumPage" => 0,
  "ListCols" => array (
      0 => 200,
      1 => 201, // nom
      2 => 243, // attitude_tribune

  ),
  "WhereCustom" => array(

    "WhereCustoms" => array(
      0 => array(
        "WhereCustoms" => NULL,
        "Criteria" => array(
          "Operator" => 0,
          "Field" => "341",
          "Value" => $nim
        ),

      "InterOperator" => 0,
      ),

      1 => array(
        "WhereCustoms" => NULL,
        "Criteria" => array(
          "Operator" => 0,
          "Field" => "327", // Fermé non coché
          "Value" => 0
         ),
         "InterOperator" => 1,
       ),

      2 => array(
        "WhereCustoms" => NULL,
        "Criteria" => array(
          "Operator" => 0,
          "Field" => "353", // Archiver non cochée
          "Value" => 0,
        ),
      'InterOperator' => 1,
      ),

      3 => array(
        "WhereCustoms" => NULL,
        "Criteria" => array(
          "Operator" => 0,
          "Field" => "411", // Adresse active
          "Value" => 1,
        ),
      'InterOperator' => 1,
      ),

      4 => array(
        "WhereCustoms" => NULL,
        "Criteria" => array(
          "Operator" => 0,
          "Field" => "412", // Adresse principale
          "Value" => 1,
        ),
      'InterOperator' => 1,
      )
    ), // end WhereCustoms

    "Criteria" => NULL,
    "InterOperator" => 0,

  ), // end WhereCustom

  "OrderBy" => array(
    0 => array(
      "DescId" => 0,
      "Order" => 0
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
curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);  // TRUE retour ss forme de chaîne et non affichage direct

$curl_response = curl_exec($curl_handle);

if ($curl_response === false) {
  $info = curl_getinfo($curl_handle);
  curl_close($curl_handle);
  die('error occurred during curl exec. Additional info: ' . var_dump($info));
}

curl_close($curl_handle);


// if we have a response...
$decoded_response = json_decode($curl_response, true);
// echo "DEBUG from '2_search_from_nim_nom.php' = "; var_dump($decoded_response); die();

if ($decoded_response['ResultInfos']['ApiMessage'] == "Aucun enregistrment trouvé" // attention il y a une faute
  || $decoded_response['ResultMetaData']['TotalRows'] == 0) { // + sûr
  $result_data['error'] = 'nim unknown';
} elseif ($decoded_response['ResultMetaData']['TotalRows'] > 1) {
  $result_data['error'] = 'nim is not unique';
}
else {
  $result_data['success']['nom'] = $decoded_response['ResultData']['Rows'][0]['Fields'][0]['DbValue'];
  $result_data['success']['attitude_tribune'] = $decoded_response['ResultData']['Rows'][0]['Fields'][1]['Value'];
  $result_data['success']['pp_id'] = $decoded_response['ResultData']['Rows'][0]['Fields'][1]['FileId'];
}

/* echo "DEBUG = "; var_dump($result_data['success']['nom']) . "<br>"
  . var_dump($result_data['success']['nom']) . "<br>"
  . var_dump($result_data['success']['attitude_tribune']) . "<br>"
  . var_dump($result_data['success']['pp_id']) . "<br>"
; die(); */

?>
