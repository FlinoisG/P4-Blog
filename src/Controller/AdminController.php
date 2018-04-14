<?php

namespace App\Controller;

use App\Repository\PostRepository;
use App\Repository\CommentRepository;
use App\Auth\Auth;
use App\Entity\Post;
use App\Entity\NotifWindow;
use App\Service\CommentService;

/**
 * Post controller that will require requested back-office views
 */
class AdminController extends DefaultController{

    /**
     * Url : ?p=admin.post
     *
     * @return void
     */
    public function post(){
        if (isset($_GET['login'])){
            $Auth = new Auth();
            $Auth->login($_POST['username'], $_POST['password']);
        }
        if (!$_SESSION){
            header("Location: ?p=admin.connection");
            die();
        }
        $PostRepository = new PostRepository();
        $CommentRepository = new CommentRepository();
        if (isset($_GET['delete'])){
            $PostRepository->deletePost($_GET['delete']);
        }
        
        require('../src/View/Admin/PostView.php');
    }

    /**
     * Url : ?p=admin.posteditor
     *
     * @return void
     */
    public function posteditor(){
        if (!$_SESSION){
            header("Location: ?p=admin.connection");
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

    /**
     * Url : ?p=admin.comments&id=*
     *
     * @param int $params id of the post to comment
     * @return void
     */
    public function comments($params){
        if (!$_SESSION){
            header("Location: ?p=admin.connection");
            die();
        }
        $PostRepository = new PostRepository();
        $CommentRepository = new CommentRepository();

        if (isset($_GET['delete'])){
            $CommentRepository->deleteComment($_GET['delete']);
        }
        if (isset($_GET['deleteFlag'])){
            $CommentService = new CommentService;
            $CommentService->removeFlag($_GET['deleteFlag']);
        }
        if (!isset($_GET['id'])){
            die($this->error('404'));
        } else {
            $id = $_GET['id'];
        }
        
        require('../src/View/Admin/CommentView.php');
    }

    /**
     * Url : ?p=admin.connection
     *
     * @return void
     */
    public function connection(){
        require('../src/View/ConnectionView.php');
    }

    /**
     * Url : ?p=admin.post_submit
     * send the posted article to either edit or submit it in the database
     *
     * @param int $id if empty, will submit a new post. otherwise, update post
     */
    public function post_submit($id = null){
        if (!$_SESSION){
            header("Location: ?p=admin.connection");
            die();
        }
        $PostRepository = new PostRepository();
        $CommentRepository = new CommentRepository();
        $allowedTags='<p><strong><em><u><h1><h2><h3><h4><h5><h6><img>';
        $allowedTags.='<li><ol><ul><span><div><br><ins><del>';
        $sHeader = strip_tags(stripslashes($_POST['post-title']),$allowedTags);
        $sContent = strip_tags(stripslashes($_POST['post-content']),$allowedTags);
        if (strlen($_POST['post-title']) <= 2){
            $NotifWindow = new NotifWindow('red', 'Article non envoyé, Titre trop court.');
        } elseif (strlen($_POST['post-content']) <= 2){
            $NotifWindow = new NotifWindow('red', 'Article non envoyé, contenu trop court.');
        } else {
            $titre = $sHeader;
            $content = $sContent;
            $postToSubmit = new Post(null, $titre, $content, date("Y-m-d H:i:s"));
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