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

    public function posteditor(){
        if (!$_SESSION){
            header("Location: /public/?p=admin.connection");
            die();
        }
        if (isset($_GET['params'])){
            $PostRepository = new PostRepository();
            $post = $PostRepository->getPosts($_GET['params']);
        } else {
            $post = null;
        }
        require('../src/View/Admin/PostEditorView.php');
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

    public function post_submit($id = null){
        if (!$_SESSION){
            header("Location: /public/?p=admin.connection");
            die();
        }
        $PostRepository = new PostRepository();
        $CommentRepository = new CommentRepository();
        if (strlen($_POST['post-title']) <= 2){
            $NotifWindow = new NotifWindow('red', 'Article non envoyé, Titre trop court.');
        } elseif (strlen($_POST['post-content']) <= 2){
            $NotifWindow = new NotifWindow('red', 'Article non envoyé, contenu trop court.');
        } else {
            //$titre = htmlspecialchars($_POST['post-title']);
            $titre = $_POST['post-title'];
            //$titre = str_replace("'", "\'", $titre);
            //$content = htmlspecialchars($_POST['post-content']);
            $content = $_POST['post-content'];
            //$content = str_replace("'", "\'", $content);
            $postToSubmit = new Post(null, $titre, $content, null);
            $_POST = array();
            if ($id == null){
                $PostRepository->submitPost($postToSubmit);
            } else {
                $PostRepository->updatePost($postToSubmit, $id);
            }
            
        }
        header('Location: ?p=admin.post');
    }

}