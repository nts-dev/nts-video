<?php

namespace session\auth;

interface AuthenticationService
{

    const END_POINT = "login";

    /**
     * @param $traineeId
     * @param $password
     * @return mixed
     *
     *
     * Login flow
     *
     * - User enters NTS password and employee id
     * - System queries from BO user table where password and employee
     * - System returns email,
     * - System authenticates from flare api
     * - System stores token in file system
     * - System starts session
     */

    function authenticateClient($traineeId, $password);

    function storeSession($auth);

    function getSession();

}