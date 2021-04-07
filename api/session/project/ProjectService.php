<?php

namespace session\project;

use Crud;
use session\config\Constants;
use session\Network;
use session\project\dao\ProjectDao;
use session\project\dao\ProjectDaoImpl;

class ProjectService implements Crud
{

    private $projectDao;

//    private Network $network;
//    private const ENDPOINT = "subjects/";

    public function __construct()
    {
//        $this->network = new Network($session, Constants::VIDEO_SEVER_API_URL);
        $this->projectDao = new ProjectDaoImpl();

    }

    function findAll()
    {
        //                var_dump($result);

                return $this->projectDao->getAll();

//        return $this->network->invoke(
//            self::ENDPOINT,
//            \session\NetworkMethod::GET
//        );

    }

    function findById($id)
    {
        // TODO: Implement findById() method.
    }

    function deleteById($id, $object)
    {
        // TODO: Implement deleteById() method.
    }

    function edit($id, $object)
    {
        // TODO: Implement edit() method.
    }

    function save($object)
    {
        // TODO: Implement save() method.
    }

     static function generateProjectId($itemId): string
    {
        if (strlen($itemId) == 1) {
            $projectId = "P00000" . $itemId . "";
        } else if (strlen($itemId) == 2) {
            $projectId = "P0000" . $itemId . "";
        } else if (strlen($itemId) == 3) {
            $projectId = "P000" . $itemId . "";
        } else if (strlen($itemId) == 4) {
            $projectId = "P00" . $itemId . "";
        } else if (strlen($itemId) == 5) {
            $projectId = "P0" . $itemId . "";
        } else {
            $projectId = $itemId;
        }

        return $projectId;
    }
}