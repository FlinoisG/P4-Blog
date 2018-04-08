<?php

namespace APP\Auth;

use App\Controller\DefaultController;
use App\Database\mysqlQuery;

class Auth {

    public function login($username, $password){
        $mysqlQuery = new mysqlQuery();
        $username = "'".$username."'";
        $user = $mysqlQuery->sqlQuery('SELECT * FROM users WHERE username=' . $username);
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

    public function logged(){
        return $_SESSION['auth'];
    }

    

}