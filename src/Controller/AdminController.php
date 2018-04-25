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
            foreach ($PostRepository->getPosts() as $post) {
                $flaggedComs = 0;
                foreach ($CommentRepository->getComments($post->getId()) as $comment) {
                    if ($comment->getFlagged() != 0) {
                        $flaggedComs = $flaggedComs + $comment->getFlagged();
                    }
                }
                if ($flaggedComs != 0) {
                    $flaggedComs = '<span class="flag-alert">Attention : ' . $flaggedComs . ' signalement</span>';
                } else {
                    $flaggedComs = '';
                }
                $content .= 
                    '<tr>
                        <td><a class="adminPostTitle" href="?p=post.single&params=' . $post->getId() . '">' . $post->getTitle() . '</a></td>
                        <td class="hidden-md-down">' . $post->getDate() . '</td>
                        <td>
                            ' . $flaggedComs . '
                                <a class="btn btn-primary btn-admin" href="?p=admin.comments&id=' . $post->getId() . '">Gérer commentaires</a>
                                <a class="btn btn-primary btn-admin" href="?p=admin.posteditor&params=' . $post->getId() . '">Éditer</a>
                                <a id="SupprBtn' . $post->getId() . '" class="btn btn-danger btn-admin">Supprimer</a>
                        </td>
                    </tr>
                    <script>
                        var val = "' . $post->getId() . '";
                        document.addEventListener(\'click\', function (event) {
                            if (event.target.id == \'SupprBtn<?= $post->getId() ?>\'){
                                CommentWindow.init(\'Confirmer la suppression de l\\\'article\', \'?p=admin.post&delete=<?= $post->getId() ?>\');
                            }
                        });
                    </script>';
            }
        } else {
            $content = '<td colspan="4">Aucun article</td>';
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
        if (isset($_GET['params'])) {
            $PostRepository = new PostRepository();
            $post = $PostRepository->getPosts($_GET['params']);
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
            $editorAction = '?p=admin.postSubmit&params=' . $post->getId();
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
     * @param int $params id of the post to comment
     * @return void
     */
    public function comments($params)
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
            $content = '';
            foreach ($CommentRepository->getComments($id) as $comment) {
                $commentContent = str_replace('"', '\"', $comment->getContent());
                $commentContentShort = substr($commentContent, 0, 170) . '... <span class="adminExpand" id="adminExpand' . $comment->getId() . '">lire la suite</span>' ;
                $commentContentExpanded = $commentContent . "<span class=\"adminExpand\" id=\"adminExpand" . $comment->getId() . "\"> Lire moins</span>";
                $flagged;
                if ($comment->getFlagged() != 0) {
                    $flagged = '<td class="hidden-sm-down" style="color: red;">' . $comment->getFlagged() . '</td>';
                } else {
                    $flagged = '<td class="hidden-sm-down">0</td>';
                }
                $content .= '<tr>
                    <td>' . $comment->getUsername() . '</td>';
                if (strlen($comment->getContent()) > 170) {
                    $content .= '<td id="content' . $comment->getId() . '">' . $commentContentShort . '</td>';
                } else {
                    $content .= '<td id="content' . $comment->getId() . '">' . $commentContent . '</td>';
                }
                $content .= '<td class="hidden-sm-down">' . $comment->getDateShort() . '</td>';
                $content .= $flagged;
                $content .= '<td>
                            <a class="btn btn-primary btn-admin-com" href="?p=admin.comments&id=' . $comment->getArticleId() . '&deleteFlag=' . $comment->getId() . '">Enlever signalements</a>
                            <a id="SupprBtn' . $comment->getId() . '" class="btn btn-danger btn-admin-com">Supprimer</a>
                    </td>
                </tr>';
                $commentContentExpanded = str_replace('"', '\"', $commentContentExpanded);
                $commentContentShort = str_replace('"', '\"', $commentContentShort);
                $content .= "<script>
                    var expanded".$comment->getId()." = false;
                    document.addEventListener('click', function (event) {
                        if (event.target.id == 'SupprBtn".$comment->getId()."'){
                            CommentWindow.init('Confirmer la suppression du commentaire', '?p=admin.comments&id=' + \"".$comment->getArticleId()."\" + '&delete=".$comment->getId()."');
                        }
                        if (event.target.id == 'adminExpand".$comment->getId()."'){                            
                            if (expanded".$comment->getId()."){
                                document.getElementById('content".$comment->getId()."').innerHTML = \"".$commentContentShort."\";
                                expanded".$comment->getId()." = false;
                            } else {
                                document.getElementById('content".$comment->getId()."').innerHTML = \"".$commentContentExpanded."\";
                                expanded".$comment->getId()." = true;
                            }
                        }
                    });
                </script>";
            }
        } else {
            $content = '<td colspan="5">Aucun commentaire</td>';
        }
        require('../src/View/Admin/CommentView.php');
    }

    /**
     * Url : ?p=admin.connection
     *
     * @return void
     */
    public function connection()
    {
        $title = "Blog de Jean Forteroche - Connection";
        $header = '';
        if (isset($_GET['forgottenPassword'])) {
            $content = "
            <form action=\"?p=admin.connection&link=sent\" method=\"post\">
                <div class=\"form-group\">
                    <label for=\"loginUsername\">Adresse mail</label>
                    <input class=\"form-control login-form\" type=\"email\" id=\"loginEmail\" name=\"email\" placeholder=\"Adresse mail\" required>
                </div>
                <button type=\"submit\" class=\"btn btn-primary\">Réinitialiser mon mot de passe</button>
            </form>
            <script src=\"assets/js/ConfirmPasswordReset.js\"></script>
            ";
        } else {
            if (isset($_GET['link'])) {
                $Auth = new Auth();
                $token = $Auth->passwordResetLink(htmlspetialchars($_POST['email']));
                $link = "<br><p>Un email contenant un lien vous permettant de réinitialiser votre mot de passe vous à été envoyé.<p>
                        <p>Le lien ne restera actif que 24 heurs.</p>";
            } else {
                $link = "<a href=\"?p=admin.connection&forgottenPassword=true\">Mot de passe oublié ?</a>";
            }
            $content = "
            <form action=\"?p=admin.post&login=true\" method=\"post\">
                <div class=\"form-group\">
                    <label for=\"loginUsername\">Nom du compte</label>
                    <input class=\"form-control login-form\" type=\"text\" id=\"loginUsername\" name=\"username\" placeholder=\"Nom du compte\">
                </div>
                <div class=\"form-group\">
                    <label for=\"loginPassword\">Mot de passe</label>
                    <input class=\"form-control login-form\" type=\"password\" id=\"loginPassword\" name=\"password\" placeholder=\"Mot de passe\">
                    ".$link."
                </div>
                <button type=\"submit\" class=\"btn btn-primary\">Envoyer</button>
            </form>
            ";
        }
        require('../src/View/EmptyView.php');
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
