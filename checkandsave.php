<?php
$c = curl_init();
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4); 
    $contents = curl_exec($c);
    $err  = curl_getinfo($c,CURLINFO_HTTP_CODE);
    curl_close($c);
require_once __DIR__ . '/facebook-php-sdk-v4/src/Facebook/autoload.php';
$fb = new Facebook\Facebook([
  'app_id' => '1398820037090778',
  'app_secret' => '77f17383fc3fe504db3cd8aac38d53ce',
  'default_access_token' => 'CAAT4OBcmYPwBAJVOpFfPZAkAAIu876rb4Mp6nXk5qhYQUrvWYMTqZCggiqvoH0c3giWkCaZBkiZCnFUfl5Uub0O1CpCxL2lWweDbk12abQNB2mTZBYze3wcPDVtPERPFxmyN8BiR7Br0ZCYj5Y1altMEi8okdw5ASn7msz3clEABf2Tr2czV6SLwQ083cpdZAcZD',
  'default_graph_version' => 'v2.2',
  ]);
$request = $fb->request('GET', '/me');
// Send the request to Graph
try {
  $response = $fb->getClient()->sendRequest($request);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

$graphNode = $response->getGraphNode();

var_dump($graphNode);
?>