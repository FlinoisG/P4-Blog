<?php

namespace App\Controller;

use App\Repository\PostRepository;
use App\Repository\CommentRepository;
use App\Database\mysqlQuery;
use App\Entity\Comment;
use App\Entity\NotifWindow;

class PostController extends DefaultController{

    public function index(){
        $PostRepository = new PostRepository();
        $CommentRepository = new CommentRepository();
        $comments = $CommentRepository->getComments();
        require('../src/View/IndexView.php');
    }

}