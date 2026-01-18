<?php
// run_c_code.php
header('Content-Type: application/json');

if(!isset($_POST['code'])){
    echo json_encode(['output'=>"No code provided"]);
    exit;
}

$code = $_POST['code'];

// JDoodle API credentials
$clientId = "YOUR_CLIENT_ID";
$clientSecret = "YOUR_CLIENT_SECRET";
$script = $code;
$language = "c";
$versionIndex = "0";

$postData = json_encode([
    "script" => $script,
    "language" => $language,
    "versionIndex" => $versionIndex,
    "clientId" => $clientId,
    "clientSecret" => $clientSecret
]);

$ch = curl_init("https://api.jdoodle.com/v1/execute");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

$response = curl_exec($ch);
curl_close($ch);

echo $response;
?>
