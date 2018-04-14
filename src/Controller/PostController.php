<?php

namespace App\Controller;

use App\Repository\PostRepository;
use App\Repository\CommentRepository;
use App\Database\mysqlQuery;
use App\Entity\Comment;
use App\Entity\NotifWindow;
use App\Service\CommentService;

/**
 * Post controller that will require requested front-office views
 */
class PostController extends DefaultController{

    /**
     * Url : ?p=post.index
     * provide every posts in one page
     *
     * @return void
     */
    public function index(){
        $PostRepository = new PostRepository();
        $CommentRepository = new CommentRepository();
        $comments = $CommentRepository->getComments();
        require('../src/View/IndexView.php');
    }

    /**
     * Url : ?p=post.single&params=$id
     * provide the requested post and its comments
     *
     * @param int $id
     * @return void
     */
    public function single($id){
        $this->checkParams();
        $PostRepository = new PostRepository();
        $post = $PostRepository->getPosts($id);
        if ($post == NULL){
            $controller = new DefaultController();
            die($this->error('404'));
        }
        if (isset($_GET['notif'])){
            switch($_GET['notif']){
                case "username":
                    $NotifWindow = new NotifWindow('red', 'Message non envoyé, nom d\'utilisateur trop court.');
                    break;
                case "content":
                    $NotifWindow = new NotifWindow('red', 'Message non envoyé, contenu trop court.');
                    break;
            }
        }
        $CommentRepository = new CommentRepository();
        $comments = $CommentRepository->getComments($id);
        require('../src/View/SingleView.php');
        if(isset($_GET['flag'])){
            $CommentService = new CommentService;
            $CommentService->flag($_GET['flag']);
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

    /**
     * Url : ?p=post.comment_submit&params=id&comment_submit=true
     * submits the comment and refresh the page
     *
     * @return void
     */
    public function comment_submit(){
        $PostRepository = new PostRepository();
        $CommentRepository = new CommentRepository();
        $post = $PostRepository->getPosts($_GET['params']);
        if (isset($_GET['comment_submit'])){
            if (strlen($_POST['comment-username']) <= 2){
                $Notif = 'username';
            } elseif (strlen($_POST['comment-content']) <= 2){
                $Notif = 'content';
            } else {
                $commentToSubmit = new Comment(NULL, htmlspecialchars($_POST['comment-username']), htmlspecialchars($_POST['comment-content']), NULL, $post->getId());
                $_POST = array();
                $CommentRepository->submitComment($commentToSubmit);
            }
        } else {
            die($this->error('500'));
        }
        header('Location: ?p=post.single&params='.$_GET['params'].'&notif='.$Notif.'#commentbox');
    }

}