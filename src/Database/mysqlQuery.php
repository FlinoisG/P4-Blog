<?php

namespace App\Database;

use App\Entity\Post;
use App\Controller\DefaultController;
use PDO;

/**
 * used for comunication with the database
 */
class mysqlQuery {

    /**
     * Undocumented variable
     * @var string
     */
    private $host;
    private $dbname;
    private $username;
    private $password;

    /**
     * Stores database 
     */
    public function __construct(){
        $configs = include('mysqlConfig.php');
        $this->host = $configs['host'];
        $this->dbname = $configs['dbname'];
        $this->username = $configs['username'];
        $this->password = $configs['password'];
    }

    /**
     * Take a sql request and return the result
     *
     * @param string $query
     * @return mixed
     */
    public function sqlQuery($query){
        try
        {
            $bdd = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbname . ';charset=utf8', $this->username, $this->password);
        }
        catch (Exeption $e)
        {
            die('Erreur : ' . $e->getMessage());
        }
        $query = $bdd->query($query);        
        if(!$query){
            $DefaultController = new DefaultController();
            die($DefaultController->error('500'));
        }
        $result = $query->fetchAll();
        return $result;
    }
}