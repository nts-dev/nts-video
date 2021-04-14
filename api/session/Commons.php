<?php


define('ROOTPATH', __DIR__);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


session_start();

include(ROOTPATH . "/bootstrap/lib/index.php");
include(ROOTPATH . '/bootstrap/Constants.php');
include(ROOTPATH . "/bootstrap/XML.php");


/**
 *
 *
 *
 *
 *
 *
 * Network dependencies
 */
include(ROOTPATH . "/bootstrap/network/NetworkMethod.php");
include(ROOTPATH . '/bootstrap/network/RequestType.php');


include (ROOTPATH . '/project/model/Project.php');


include(ROOTPATH . '/bootstrap/config/SessionDatabase.php');

include(ROOTPATH . "/bootstrap/App.php");
include(ROOTPATH . '/bootstrap/network/Network.php');
include(ROOTPATH . '/crudbase/IMediaService.php');
include(ROOTPATH . '/crudbase/IModuleService.php');
include(ROOTPATH . '/crudbase/Crud.php');
include(ROOTPATH . '/media/MediaService.php');
include(ROOTPATH . '/content/ContentService.php');





include (ROOTPATH . '/project/dao/ProjectQueryExecutor.php');
include (ROOTPATH . '/project/dao/ProjectDao.php');
include (ROOTPATH . '/project/dao/ProjectDaoImpl.php');
include (ROOTPATH . '/project/ProjectService.php');







