<?php

namespace session\auth\dao;


use User;



class UserDaoImp implements UserDao
{

    private QueryExecutor $queryExecutor;

    function __construct()
    {
        $this->queryExecutor = new QueryExecutor();
    }

    public function getUser($traineeId, $password): ?User
    {
        $result = $this->queryExecutor->query($traineeId, $password);
//        var_dump($result);

        if ($result->rowCount() < 1)
            return null;

        $row = $result->fetch();
        $user = new User();
        $user->setEmail($row['email']);
        $user->setFirstName($row['firstName']);
        $user->setLastName($row['lastName']);
        $user->setPassword($password);
        $user->setTraineeId($traineeId);

        return $user;

    }
}