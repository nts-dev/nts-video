<?php

namespace session\project;

use Crud;
use session\config\Constants;
use session\Network;
use session\project\dao\ProjectDao;
use session\project\dao\ProjectDaoImpl;

class ProjectService implements Crud
{

//    private ProjectDao $projectDao;

    private Network $network;
    private const ENDPOINT = "subjects/";

    public function __construct($session)
    {
        $this->network = new Network($session, Constants::VIDEO_SEVER_API_URL);

    }

    function findAll()
    {
//        $result =  $this->projectDao->getAll();

        //        var_dump($result);

        return $this->network->invoke(
            self::ENDPOINT,
            \session\NetworkMethod::GET
        );

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
}