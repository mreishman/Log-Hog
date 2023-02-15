<?php
require_once("../class/core.php");
$core = new core();
require_once("../class/session.php");
$session = new session();
if(!$session->startSession())
{
  echo json_encode(array("error" => 14));
  exit();
}
if(!$session->validate())
{
  echo json_encode(array("error" => 18));
  exit();
}

$returnData = array(
  "success"   => "true"
);


// $curl = curl_init();

// curl_setopt_array($curl, array(
//         CURLOPT_URL => "https://api.bigcommerce.com/stores/".$store_hash."/v3/store/systemlogs",
//   CURLOPT_RETURNTRANSFER => true,
//   CURLOPT_ENCODING => "",
//   CURLOPT_MAXREDIRS => 10,
//   CURLOPT_TIMEOUT => 0,
//   CURLOPT_FOLLOWLOCATION => true,
//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//   CURLOPT_CUSTOMREQUEST => "GET",
//   CURLOPT_HTTPHEADER => array(
//           "Content-Type: application/json",
//     "X-Auth-Token: "
//   ),
// ));

// $response = curl_exec($curl);

// curl_close($curl);
// file_put_contents('test.log', $response['data']);





echo json_encode($returnData);

?>