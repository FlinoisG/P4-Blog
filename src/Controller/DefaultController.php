<?php

namespace App\Controller;

class DefaultController {

    public function error($error){
        $errorF = '../src/View/Error/' . $error . 'View.php';
        if (file_exists($errorF)){
            require('../src/View/Error/' . $error . 'View.php');
        } else {
            require('../src/View/Error/500View.php');
        }
    }

    public function checkParams(){
        if (!isset($_GET['params'])){
            die($this->error('404'));
        } else {
            $id = $_GET['params'];
        }
    }

}