<?php

date_default_timezone_set("America/Mexico_City");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'google-api-php-client-2.4.0_PHP54/vendor/autoload.php';
define('STDIN',fopen("php://stdin","r"));
// 4/wgGsoId0wQqwGRLoWbxOyGblvNyKophw-B_Yf6yngeAh-TnkAhixEMM
//if (php_sapi_name() != 'cli') {
  //  throw new Exception('This application must be run on the command line.');
//}

/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function getClient()
{
    $client = new Google_Client();
    $client->setApplicationName('Google Sheets API PHP Quickstart');
    $client->setScopes(Google_Service_Sheets::SPREADSHEETS_READONLY);
    $client->setAuthConfig(dirname(__FILE__).'/credentials.json');
    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');

    // Load previously authorized token from a file, if it exists.
    // The file token.json stores the user's access and refresh tokens, and is
    // created automatically when the authorization flow completes for the first
    // time.
    $tokenPath = dirname(__FILE__).'/token.json';
    if (file_exists($tokenPath)) {
        $accessToken = json_decode(file_get_contents($tokenPath), true);
        $client->setAccessToken($accessToken);
    }

    // If there is no previous token or it's expired.
    if ($client->isAccessTokenExpired()) {
        // Refresh the token if possible, else fetch a new one.
        if ($client->getRefreshToken()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        } else {
            // Request authorization from the user.
            $authUrl = $client->createAuthUrl();
            printf("Open the following link in your browser:\n%s\n", $authUrl);
            print 'Enter verification code: ';
            $authCode = trim(fgets(STDIN));
               $authCode=  'aqui insertar tu codigo que te dara google';
            // Exchange authorization code for an access token.
            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
            $client->setAccessToken($accessToken);

            // Check to see if there was an error.
            if (array_key_exists('error', $accessToken)) {
                throw new Exception(join(', ', $accessToken));
            }
        }
        // Save the token to a file.
        if (!file_exists(dirname($tokenPath))) {
            mkdir(dirname($tokenPath), 777, true);
        }
        file_put_contents($tokenPath, json_encode($client->getAccessToken()));
    }
    return $client;
}


// Get the API client and construct the service object.
function getdata($range){
$client = getClient();
$service = new Google_Service_Sheets($client);

// Prints the names and majors of students in a sample spreadsheet:
// https://docs.google.com/spreadsheets/d/1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgvE2upms/edit
//https://docs.google.com/spreadsheets/d/1Ju37Bsn-8JguN8Xd8-fVS9HPFsiT1dgi/edit#gid=550717797
 $spreadsheetId = 'aqui el id de tu libro de google';
$val=array();
foreach ($range as  $data) {
 
$response = $service->spreadsheets_values->get($spreadsheetId, $data);
$values = $response->getValues();
$val[]=array($data=>$values);
//if (empty($values)) {
   // echo  "<br><br><br>No data found";
//} else {
    //echo "<br><br><br> data sheet  ".$data;
    //echo json_encode(array($data=>$values) );
   // foreach ($values as $row) {
        // Print columns A and E, which correspond to indices 0 and 4.
       // printf("%s, %s\n", $row[0], $row[4]);
   // }
//}

}

return $val;
}
function getdataconfig($range,$spreadsheetId){
$client = getClient();
$service = new Google_Service_Sheets($client);

// Prints the names and majors of students in a sample spreadsheet:
// https://docs.google.com/spreadsheets/d/1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgvE2upms/edit
//https://docs.google.com/spreadsheets/d/1Ju37Bsn-8JguN8Xd8-fVS9HPFsiT1dgi/edit#gid=550717797
$spreadsheetId = 'aqui tu id de libro';
//$range = array('Ef Fisica','Ef Comercial','Ef Energetica');
$val=array();
foreach ($range as  $data) {
 
$response = $service->spreadsheets_values->get($spreadsheetId, $data);
$values = $response->getValues();
$val[]=array($data=>$values);
//if (empty($values)) {
   // echo  "<br><br><br>No data found";
//} else {
    //echo "<br><br><br> data sheet  ".$data;
    //echo json_encode(array($data=>$values) );
   // foreach ($values as $row) {
        // Print columns A and E, which correspond to indices 0 and 4.
       // printf("%s, %s\n", $row[0], $row[4]);
   // }
//}

}

return $val;
}

 //$a= getdata(array('Ef Fisica','Ef Comercial','Ef Energetica'));
//echo json_encode($a);
?>
