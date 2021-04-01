<?php
header("Content-Type: application/json; charset=UTF-8");
use session\auth\AuthenticationServiceImpl;


include('Commons.php');


$payload = json_decode(file_get_contents('php://input'), 1);

$service = new AuthenticationServiceImpl();

//$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
//$email =    filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);

$resultArray = $service->authenticateClient(
    $payload['email'],
    $payload['password']
);
