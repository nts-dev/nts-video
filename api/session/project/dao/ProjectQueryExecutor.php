<?php

namespace session\project\dao;

use SessionDatabase;

class ProjectQueryExecutor
{
    private $conn;

    function __construct()
    {
        $this->conn = SessionDatabase::getInstance()::getConnection();
    }

    public function __destruct()
    {
        $this->conn = NULL;
    }

    function findAll()
    {
        $query = /** @lang text */
            "
                SELECT
                    projects_dir.id,
                    projects_dir.parent_id,

            IF(
                    ISNULL(
                            projects_dir_translation.title
                    ),
                    projects_dir.project_name,
                    projects_dir_translation.title
            )title,
             sort_id
            FROM
                    projects_dir
            LEFT JOIN projects_dir_translation ON projects_dir_translation.project_id = projects_dir.id
             AND projects_dir_translation.language_id =1 AND projects_dir.has_training = 1
             JOIN project_to_branch ON project_to_branch.project_id = projects_dir.id AND project_to_branch.branch_id =1
            

            -- WHERE
            -- projects_dir.has_training = 1 AND archive = 0  
            ";


        $statement = $this->conn->prepare($query);
        $statement->execute();
        return $statement;
    }
}