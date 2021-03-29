<?php

use session\project\ProjectService;
use session\RequestType;

$action = $_GET['action'];
include('Commons.php');


$bootstrap = App::getInstance();


$session = $bootstrap::startSessionIfNotAvailable(
    filter_input(INPUT_GET, 'trainee', FILTER_SANITIZE_STRING),
    filter_input(INPUT_GET, 'identifier', FILTER_SANITIZE_STRING)
);

$service = new ProjectService($session);

switch ($action) {

    case RequestType::PROJECT_ALL:
        $result = $service->findAll();
        XML::projectGrid($result);
        break;

    case RequestType::PROJECT_COMBO:
        $result = $service->findAll();
        XML::combo($result);
        break;
}