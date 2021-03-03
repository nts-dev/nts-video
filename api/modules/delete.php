<?php


include_once '../core.php';


$database = new Database();

$db = $database->getConnection();

$media = new Media($db);

$incomingData = json_decode(file_get_contents("php://input"));

if (isset($incomingData->content_id)) {
    $result = $media->content_DELETE($incomingData->content_id);

    if ($result) {
       
        http_response_code(201);
        echo '{"message":"Delete success", "status":"Success"}';
    } else {
        // set response code - 503 service unavailable
        http_response_code(503);
        // tell the user
        echo '{"message":" Delete fail", "status": "Fail"}';
    }
} else {
    http_response_code(400);
    echo '{"message":"Fail. Module not set", "status": "Fail"}';
}


