<?php

namespace App\Controller;

use App\Repository\PostRepository;
use App\Database\mysqlQuery;
use App\Entity\NotifWindow;

class PostController extends DefaultController{

    public function index(){
        $PostRepository = new PostRepository();
        require('../src/View/IndexView.php');
    }

    public function single($id){
        $this->checkParams();
        $PostRepository = new PostRepository();
        $post = $PostRepository->getPosts($id);
        if ($post == NULL){
            $controller = new DefaultController();
            die($this->error('404'));
        }
        require('../src/View/SingleView.php');
    }

}