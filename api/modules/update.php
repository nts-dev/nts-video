<?php


include_once '../core.php';

$database = new Database();

$db = $database->getConnection();

$media = new Media($db);

// get posted data
$incomingData = json_decode(file_get_contents("php://input"));


$result = $media->content_UPDATE($incomingData->content_id, $incomingData->content_name, $incomingData->content_description);


if ($result) {

    http_response_code(201);
    echo '{"message":"Update success", "status":"Success"}';
} else {
    http_response_code(503);
    // tell the user
    echo '{"message":"Content update fail", "status":"Fail"}';
}