<?php

namespace session\auth\dao;

interface UserDao
{

    function getUser($traineeId, $password);

}