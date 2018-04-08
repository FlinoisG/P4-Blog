<?php

namespace App\Controller;

use App\Repository\PostRepository;
use App\Repository\CommentRepository;
use App\Auth\Auth;
use App\Entity\Post;
use App\Entity\NotifWindow;

class AdminController extends DefaultController{

    public function post(){
        if (isset($_GET['login'])){
            $Auth = new Auth();
            $Auth->login($_POST['username'], $_POST['password']);
        }
        if (!$_SESSION){
            header("Location: /public/?p=admin.connection");
            die();
        }
        $PostRepository = new PostRepository();
        $CommentRepository = new CommentRepository();
        if (isset($_GET['delete'])){
            $PostRepository->deletePost($_GET['delete']);
        }
        
        require('../src/View/Admin/PostView.php');
    }

    public function comments($params){
        if (!$_SESSION){
            header("Location: /public/?p=admin.connection");
            die();
        }
        $PostRepository = new PostRepository();
        $CommentRepository = new CommentRepository();

        if (isset($_GET['delete'])){
            $CommentRepository->deleteComment($_GET['delete']);
        }
        if (isset($_GET['deleteFlag'])){
            $PostController = new PostController();
            $PostController->removeFlag($_GET['deleteFlag']);
        }
        if (!isset($_GET['id'])){
            die($this->error('404'));
        } else {
            $id = $_GET['id'];
        }
        
        require('../src/View/Admin/CommentView.php');
    }

    public function connection(){
        require('../src/View/ConnectionView.php');
    }



}