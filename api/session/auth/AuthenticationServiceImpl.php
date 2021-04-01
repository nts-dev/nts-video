<?php

namespace session\auth;


use session\auth\dao\UserDao;
use session\auth\dao\UserDaoImp;
use session\config\Constants;

use User;
use UserSession;


class AuthenticationServiceImpl implements AuthenticationService
{

    private UserDao $dao;

    function __construct()
    {
        $this->dao = new UserDaoImp();
    }


    function authenticateClient($traineeId, $password) : bool
    {

        assert($traineeId != null);
        assert($password != null);

        /**
         *
         * 1 Authenticate user from BO
         */
        $BOAuthenticatedUser = $this->authenticateFromBO($traineeId, $password);
//        var_dump($BOAuthenticatedUser);

        if ($BOAuthenticatedUser == null) {
            echo json_encode(array("response" => false, "state" => 'fail', "message" => 'ID or password does not exist'));
            return false;
        }


        /**
         *
         * 2 Request token from flare api
         */
        $authResultJSON = $this->authenticateFromFlare($BOAuthenticatedUser);

        $authResult = json_decode($authResultJSON);


        /**
         *
         * 3 Store user session
         */


        if ($authResult->access_token) {
            $userSession = new UserSession();

            $userSession->setToken($authResult->access_token);
            $userSession->setTokenType($authResult->token_type);
            $userSession->setExpires($authResult->expires_at);
            $this->storeSession($userSession);

//            echo json_encode(array("response" => true, "state" => 'success', "message" => "Welcome, your session started", "token" => $authResult->access_token));
            echo $authResultJSON;
            return true;
        }


        return false;
    }

    private function authenticateFromBO($traineeId, $password): ?User
    {
        return $this->dao->getUser($traineeId, $password);

    }

    private function authenticateFromFlare(User $user)
    {

        assert($user != null);

        $ch = curl_init();


        $data = array(
            "is_offline" => 1,
            "internal" => 1,
            "display_name" => $user->getFirstName(),
            "first_name" => $user->getFirstName(),
            "last_name" => $user->getLastName(),
            "email" => $user->getEmail(),
            "password" => $user->getPassword());

        $POST = json_encode($data);

        $URL = Constants::API_URL . self::END_POINT;

        $HEADER = [
            'Content-Type: application/json'
        ];


        curl_setopt($ch, CURLOPT_URL, $URL);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $POST);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $HEADER);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_VERBOSE, true);

        $server_output = curl_exec($ch);

        curl_close($ch);

        return $server_output;

    }

    function storeSession($auth)
    {

        assert($auth != null);
//        session_start();
        $_SESSION["USER"] = serialize($auth);
        session_commit();


    }

    function getSession(): ?UserSession
    {

        if ($this->sessionExists()) {

            $session = $_SESSION["USER"];
//            var_dump($session);

            return unserialize($session);
        }
        return null;
    }


    private function sessionExists(): bool
    {
        return !empty($_SESSION) && isset($_SESSION['USER']);
    }

}