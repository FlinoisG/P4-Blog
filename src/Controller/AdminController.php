<?php

namespace App\Controller;

use App\Repository\PostRepository;
use App\Repository\CommentRepository;
use App\Auth\Auth;
use App\Entity\Post;
use App\Entity\NotifWindow;
use App\Service\CommentService;
use App\Database\mysqlQuery;
use App\Controller\DataController;

/**
 * Post controller that will require requested back-office views
 */
class AdminController extends DefaultController
{

    /**
     * Url : ?p=admin.post
     *
     * @return void
     */
    public function post()
    {
        $title = 'Blog de Jean Forteroche - Administration des articles';
        $header = '';
        if (isset($_GET['login'])) {
            $Auth = new Auth();
            $Auth->login($_POST['username'], $_POST['password']);
        }
        if (!$_SESSION) {
            header("Location: ?p=admin.connection");
            die();
        }
        $PostRepository = new PostRepository();
        $CommentRepository = new CommentRepository();
        if (isset($_GET['delete'])) {
            $PostRepository->deletePost($_GET['delete']);
        }
        $content = '';
        if (sizeof($PostRepository->getPosts()) > 0) {
            $i = 0;
            $id;
            $title;
            $date;
            $flaggedComs;
            foreach ($PostRepository->getPosts() as $post) {
                $title[$i] = $post->getTitle();
                $date[$i] = $post->getDate();
                $id[$i] = $post->getId();
                $flaggedComs[$i] = 0;
                foreach ($CommentRepository->getComments($post->getId()) as $comment) {
                    if ($comment->getFlagged() != 0) {
                        $flaggedComs[$i] = $flaggedComs[$i] + $comment->getFlagged();
                    }
                }
                if ($flaggedComs[$i] != 0) {
                    $flaggedComs[$i] = '<span class="flag-alert">Attention : ' . $flaggedComs[$i] . ' signalement</span>';
                } else {
                    $flaggedComs[$i] = '';
                }
                ;
                $script[$i] .=
                    '<script>
                        var val = "' . $id . '";
                        document.addEventListener(\'click\', function (event) {
                            if (event.target.id == \'SupprBtn' . $id . '\'){
                                CommentWindow.init(\'Confirmer la suppression de l\\\'article\', \'?p=admin.post&delete=' . $id . '\');
                            }
                        });
                    </script>';
            }
            $extra = '';
        } else {
            $extra = '<td colspan="4">Aucun article</td>';
        }
        require('../src/View/Admin/PostView.php');
    }

    /**
     * Url : ?p=admin.posteditor
     *
     * @return void
     */
    public function posteditor()
    {
        if (!$_SESSION) {
            header("Location: ?p=admin.connection");
            die();
        }
        if (isset($_GET['article'])) {
            $PostRepository = new PostRepository();
            $post = $PostRepository->getPosts($_GET['article']);
        } else {
            $post = null;
        }
        $title = "Blog de Jean Forteroche - Editeur d'article";
        $header = '<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=ytdbv6007rzv009uec0hsu3v0b57g8mcs0o9l6ik6e4du5iy"></script>
        <script>
            tinymce.init({
                
                mode: "exact",
                elements : "elm1",
                selector:\'textarea\',
                width: 871,
                min_height: 500,
            });
        </script>';
        if ($post != null) {
            $editorTitle = $post->getTitle();
            $editorContent = $post->getContent();
            $editorAction = '?p=admin.postSubmit&article=' . $post->getId();
        } else {
            $editorTitle = '';
            $editorContent = '';
            $editorAction = '?p=admin.postSubmit';
        }
        require('../src/View/Admin/PostEditorView.php');
    }

    /**
     * Url : ?p=admin.comments&id=*
     *
     * @param int $article id of the post to comment
     * @return void
     */
    public function comments($article)
    {
        $title = 'Blog de Jean Forteroche - Administration des commentaires';
        $header = '';
        if (!$_SESSION) {
            header("Location: ?p=admin.connection");
            die();
        }
        $PostRepository = new PostRepository();
        $CommentRepository = new CommentRepository();

        if (isset($_GET['delete'])) {
            $CommentRepository->deleteComment($_GET['delete']);
        }
        if (isset($_GET['deleteFlag'])) {
            $CommentService = new CommentService;
            $CommentService->removeFlag($_GET['deleteFlag']);
        }
        if (!isset($_GET['id'])) {
            die($this->error('404'));
        } else {
            $id = $_GET['id'];
        }
        if (sizeof($CommentRepository->getComments()) > 0) {
            $i = 0;
            $flagged;
            $username;
            $content;
            $dateShort;
            $articleId;
            foreach ($CommentRepository->getComments($id) as $comment) {
                $commentId[$i] = $comment->getId();
                $commentContent[$i] = str_replace('"', '\"', $comment->getContent());
                $commentContentShort[$i] = substr($commentContent[$i], 0, 170) . '... <span class="adminExpand" id="adminExpand' . $commentId[$i] . '">lire la suite</span>' ;
                $commentContentExpanded[$i] = $commentContent[$i] . "<span class=\"adminExpand\" id=\"adminExpand" . $commentId[$i] . "\"> Lire moins</span>";
                $username[$i] = $comment->getUsername();
                $content[$i] = $comment->getContent();
                $dateShort[$i] = $comment->getDateShort();
                $articleId[$i] = $comment->getArticleId();
                if ($comment->getFlagged() != 0) {
                    $flagged[$i] = '<td class="hidden-sm-down" style="color: red;">' . $comment->getFlagged() . '</td>';
                } else {
                    $flagged[$i] = '<td class="hidden-sm-down">0</td>';
                }
                if (strlen($content[$i]) > 170) {
                    $contentLength[$i] = '<td id="content'.$commentId[$i].'">'.$commentContentShort[$i].'</td>';
                } else {
                    $contentLength[$i] = '<td id="content'.$commentId[$i].'">'.$commentContent[$i].'</td>';
                }
                $commentContentExpanded[$i] = str_replace('"', '\"', $commentContentExpanded[$i]);
                $commentContentShort[$i] = str_replace('"', '\"', $commentContentShort[$i]);
                $i++;
            }
            $extra = '';
        } else {
            $extra = '<td colspan="5">Aucun commentaire</td>';
        }
        require('../src/View/Admin/CommentView.php');
    }

    /**
     * Url : ?p=admin.connection
     * Admin connection article
     *
     * @return void
     */
    public function connection()
    {
        $title = "Blog de Jean Forteroche - Connection";
        $header = '';
        if (isset($_GET['link'])) {
            $Auth = new Auth();
            $token = $Auth->passwordResetLink(htmlspecialchars($_POST['email']));
            $link = "<br><p>Un email contenant un lien vous permettant de réinitialiser votre mot de passe vous à été envoyé.<p>
                    <p>Le lien ne restera actif que 24 heurs.</p>";
        } else {
            $link = "<a href=\"?p=admin.passwordRecovery\">Mot de passe oublié ?</a>";
        }
        require('../src/View/ConnectionView.php');
    }

    public function passwordRecovery()
    {
        $title = "Blog de Jean Forteroche - Connection";
        $header = '';
        require('../src/View/PasswordRecoveryView.php');
    }

    /**
     * Url : ?p=admin.postSubmit
     * send the posted article to either edit or submit it in the database
     *
     * @param int $id if empty, will submit a new post. otherwise, update post
     */
    public function postSubmit($id = null)
    {
        if (!$_SESSION) {
            header("Location: ?p=admin.connection");
            die();
        }
        $PostRepository = new PostRepository();
        $CommentRepository = new CommentRepository();
        $allowedTags='<p><strong><em><u><h1><h2><h3><h4><h5><h6><img>';
        $allowedTags.='<li><ol><ul><span><div><br><ins><del>';
        $sHeader = strip_tags(stripslashes($_POST['post-title']));
        $sContent = strip_tags(stripslashes($_POST['post-content']), $allowedTags);
        if (strlen($_POST['post-title']) <= 2) {
            $NotifWindow = new NotifWindow('red', 'Article non envoyé, Titre trop court.');
        } elseif (strlen($_POST['post-content']) <= 2) {
            $NotifWindow = new NotifWindow('red', 'Article non envoyé, contenu trop court.');
        } else {
            $titre = $sHeader;
            $content = $sContent;
            $postToSubmit = new Post(null, $titre, $content, date("Y-m-d H:i:s"));
            $_POST = array();
            if ($id == null) {
                $PostRepository->submitPost($postToSubmit);
            } else {
                $PostRepository->updatePost($postToSubmit, $id);
            }
        }
        header('Location: ?p=admin.post');
    }

    /**
     * Url : ?p=admin.resetPassword
     * Password reset page
     *
     * @return void
     */
    public function resetPassword()
    {
        $dataController = new DataController();
        $mysqlQuery = new mysqlQuery();
        $token = $_GET['token'];
        $token = $dataController->dataValidation($token);
        $user = $mysqlQuery->sqlQuery("SELECT * FROM users WHERE passwordResetToken='".$token."'");
        if (time() > strtotime($user['0']['passwordResetExpiration'])) {
            $title = "Blog de Jean Forteroche - Réinitialisation du mot de passe";
            $header = '';
            $content = "<p>Lien expiré.</p>
            <a href=\"?p=post.index\" class=\"btn btn-primary\">Retour</a>";
            require('../src/View/EmptyView.php');
        } elseif ($user == []) {
            die($this->erreur('403'));
        } else {
            $title = "Blog de Jean Forteroche - Réinitialisation du mot de passe";
            $header = '';
            $user = $user['0']['username'];
            require('../src/View/ResetPasswordView.php');
        }
    }

    /**
     * Url : ?p=admin.newPassword
     * Confirmation page for the new password
     *
     * @return void
     */
    public function newPassword()
    {
        if ($_POST == []) {
            die($this->error('500'));
        }
        $auth = new Auth();
        $auth->resetPassword($_GET['user'], $_POST['password']);
        $title = "Blog de Jean Forteroche - Mot de passe réinitialisé";
        $header = '';
        $content = "<p>Nouveau mot de passe actualisé.</p>
        <a href=\"?p=post.index\" class=\"btn btn-primary\">Retour</a>";
        require('../src/View/EmptyView.php');
    }
}
