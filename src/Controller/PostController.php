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
        $title = "Blog de Jean Forteroche - Billet simple pour l'Alaska";
        $header = '';
        $posts = "";
        if (sizeof($PostRepository->getPosts()) > 0){
            foreach ($PostRepository->getPosts() as $post) {
                if (strlen($post->getContent()) > 500){
                    $content = substr(strip_tags($post->getContent()), 0, 500) . '... <a href="?p=post.single&params=' . $post->getId() . '">lire la suite</a>' ;
                } else {
                    $content = strip_tags($post->getContent());
                }
                $coms = 0;
                foreach ($comments as $comment) {
                    if ($comment->getArticleId() == $post->getId()){
                        $coms++;
                    }
                }
                $posts .= "<div class=\"box post\" style=\"text-align: left;\">
                <div class=\"row\">
                    <h2 class=\"post-titre titre col-lg-9\"><a href=\"?p=post.single&params=" . $post->getId() . "\"> " . $post->getTitle() ."</a>
                        <p class=\"index-commentaires\">Commentaires: " . $coms . "</p>
                    </h2>
                    <h6 class=\"post-date col-lg-3\">" . $post->getDate() . "</h6>
                </div>
                <p class=\"postContent-index\">" . $content . "</p>
                </div>";
            }
        } else {
            $posts = "<div class=\"box post\">
                <h1>Aucun article :/</h1><br>
                <p>Aucun article n'as encore été rédiger.</p>
            </div>";
        }
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
        $title = $post->getTitle() . " - Jean Forteroche, Billet simple pour l'Alaska";
        $header = '';
        if ($post == NULL){
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
        $i = 0;
        foreach ($comments as $comment) {
            if (isset($_SESSION['auth'])){
                $commentButton[$i] = '<a id="SupprBtn' . $comment->getId() . '" class="btn btn-danger comment-btn-suppr">Supprimer</a>';   
            } else {
                $commentButton[$i] = '<a class="comment-btn btn btn-outline-danger" href="?p=post.single&params=' . $post->getId() . '&flag=' . $comment->getId() . '">Signaler</a>';
            }
            $commentButton[$i] .= "<script>
            document.addEventListener('click', function (event) {
                if (event.target.id == 'SupprBtn" . $comment->getId() . "'){
                    CommentWindow.init('Confirmer la suppression du commentaire', '?p=admin.comments&id=" . $comment->getArticleId() . "&delete=" . $comment->getId() . "');
                }
            });
            </script>";
            $i++;
        }
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
     * Url : ?p=post.commentSubmit&params=id&commentSubmit=true
     * submits the comment and refresh the page
     *
     * @return void
     */
    public function commentSubmit(){
        $PostRepository = new PostRepository();
        $CommentRepository = new CommentRepository();
        $post = $PostRepository->getPosts($_GET['params']);
        if (isset($_GET['commentSubmit'])){
            if (strlen($_POST['comment-username']) <= 2){
                $Notif = 'username';
            } elseif (strlen($_POST['comment-content']) <= 2){
                $Notif = 'content';
            } else {
                $allowedTags='<p><strong><em><u><h1><h2><h3><h4><h5><h6><img>';
                $allowedTags.='<li><ol><ul><span><div><br><ins><del>';
                $sHeader = strip_tags(stripslashes($_POST['comment-username']));
                $sContent = strip_tags(stripslashes($_POST['comment-content']),$allowedTags);
                $commentToSubmit = new Comment(
                    NULL, 
                    htmlspecialchars($_POST['comment-username']), 
                    htmlspecialchars($_POST['comment-content']), 
                    NULL, 
                    $post->getId());
                $_POST = array();
                $CommentRepository->submitComment($commentToSubmit);
            }
        } else {
            die($this->error('500'));
        }
        header('Location: ?p=post.single&params='.$_GET['params'].'&notif='.$Notif.'#commentbox');
    }

}