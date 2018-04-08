<?php

namespace App\Database;

use App\Entity\Post;
use App\Controller\DefaultController;
use PDO;

class mysqlQuery {

    private $host;
    private $dbname;
    private $username;
    private $password;

    public function __construct(){
        $configs = include('mysqlConfig.php');
        $this->host = $configs['host'];
        $this->dbname = $configs['dbname'];
        $this->username = $configs['username'];
        $this->password = $configs['password'];
    }

    public function sqlQuery($query){
        try
        {
            $bdd = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbname . ';charset=utf8', $this->username, $this->password);
        }
        catch (Exeption $e)
        {
            die('Erreur : ' . $e->getMessage());
        }
        //var_dump($query);
        $query = $bdd->query($query);        
        if(!$query){
            $DefaultController = new DefaultController();
            die($DefaultController->error('500'));
        }
        $result = $query->fetchAll();
        return $result;
    }
}