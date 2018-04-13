<?php

namespace APP\Auth;

use App\Controller\DefaultController;
use App\Database\mysqlQuery;

/**
 * Auth class for authentification related functions
 */
class Auth {

    /**
     * Create session if username and password matches in the database
     *
     * @param string $username
     * @param string $password
     * @return void
     */
    public function login($username, $password){
        $mysqlQuery = new mysqlQuery();
        $user = $mysqlQuery->sqlQuery("SELECT * FROM users WHERE username='".$username."'");
        if($user != [] && $password == $user['0']['password']){
            if(!isset($_SESSION)){
                session_start();
            }
            $_SESSION['auth'] = $user['0']['username'];
            
        } else {
            $DefaultController = new DefaultController();
            die($DefaultController->error(403));
        }
    }

}