<?php

namespace session\project\dao;

use mysql_xdevapi\Exception;
use PDO;
use Project;

class ProjectDaoImpl implements ProjectDao
{

    private $executor;

    public function __construct()
    {
        $this->executor = new ProjectQueryExecutor();
    }

    function getAll(): array
    {

        $PROJECT = array();
        $result = $this->executor->findAll();

        //        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
//            $PROJECT[$row['id']]['id'] = $row['id'];
//            $PROJECT[$row['id']]['title'] = $row['title'];
//            $PROJECT[$row['id']]['project_number'] = $this->generateProjectId($row['id']);
//        }

        return $result->fetchAll(\PDO::FETCH_ASSOC);
    }

    function findById(int $id)
    {
        // TODO: Implement findById() method.
    }

    function delete(int $id)
    {
        // TODO: Implement delete() method.
    }

    function save(Project $project)
    {
        // TODO: Implement save() method.
    }


    private function generateProjectId($itemId): string
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