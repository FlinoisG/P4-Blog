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

    public function single($id){
        $this->checkParams();
        $PostRepository = new PostRepository();
        $post = $PostRepository->getPosts($id);
        if ($post == NULL){
            $controller = new DefaultController();
            die($this->error('404'));
        }
        $CommentRepository = new CommentRepository();
        $comments = $CommentRepository->getComments($id);
        require('../src/View/SingleView.php');
        if(isset($_GET['flag'])){
            $this->flag($_GET['flag']);
            $flaggedUsername;
            foreach ($comments as $comment) {
                if ($comment->getId() == $_GET['flag']){
                    $flaggedUsername = $comment->getUsername();
                }
            }
            $NotifWindow = new NotifWindow('red', 'Le commentaire de ' . $flaggedUsername . ' à bien été signalé.');            
        }
        if (isset($_GET['submit'])){
            $NotifWindow = new NotifWindow('#47ff78', 'Message envoyé.');
        }
    }

    public function comment_submit(){
        $PostRepository = new PostRepository();
        $CommentRepository = new CommentRepository();
        $post = $PostRepository->getPosts($_GET['params']);
        if (isset($_GET['comment_submit'])){
            if (strlen($_POST['comment-username']) <= 2){
                $NotifWindow = new NotifWindow('red', 'Message non envoyé, Pseudo trop court.');
            } elseif (strlen($_POST['comment-content']) <= 2){
                $NotifWindow = new NotifWindow('red', 'Message non envoyé, contenu trop court.');
            } else {
                $commentToSubmit = new Comment(NULL, htmlspecialchars($_POST['comment-username']), htmlspecialchars($_POST['comment-content']), NULL, $post->getId());
                $_POST = array();
                $CommentRepository->submitComment($commentToSubmit);
            }
        } else {

        }
        header('Location: /public/?p=post.single&params='.$_GET['params']);
    }

    

    public function flag($id){
        $mysqlQuery = new mysqlQuery();
        $mysqlQuery->sqlQuery('UPDATE commentaires SET flagged = flagged + 1 WHERE id=' . $id);
    }

    public function removeFlag($id){
        $mysqlQuery = new mysqlQuery();
        $mysqlQuery->sqlQuery('UPDATE commentaires SET flagged = 0 WHERE id=' . $id);
    }
}