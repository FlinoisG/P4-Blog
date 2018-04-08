<?php

namespace App\Controller;

use App\Repository\PostRepository;
use App\Database\mysqlQuery;

class PostController extends DefaultController{

    public function index(){
        $PostRepository = new PostRepository();
        require('../src/View/IndexView.php');
    }

}