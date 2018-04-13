<?php

use App\Entity\Comment;
use App\Entity\NotifWindow;



$title = $post->getTitle() . " - Jean Forteroche, Billet simple pour l'Alaska";
$header = '';
ob_start();

?> 
<div class="col-lg-10" style="text-align: left;">
<div class="box post">
    <div class="row">
        <h2 class="post-titre titre col-lg-8"><?= $post->getTitle() ?></h2>
        <h6 class="post-date col-lg-4"><?= $post->getDate(); ?></h6>
    </div>
    <p class="postContent-single"><?= $post->getContent(); ?></p>
    <p class="comment-header">Commentaires: <?= sizeof($comments) ?></p>
    <?php
    foreach ($comments as $comment) {
        $highlight = '';
        if (isset($_GET['highlight'])){
            if ($_GET['highlight'] == $comment->getId()){
                $highlight = ' box-highlight';
            }
        }
        ?>
        <div class="comment box<?= $highlight ?>" id="<?= $comment->getId() ?>">
        <p class="comment-username"> <?= $comment->getUsername() ?> <span class="comment-date"><?= $comment->getDate() ?></span></p>
        <p class="comment-content"> <?= $comment->getContent() ?> </p>
        <a class="comment-btn btn btn-outline-danger" href="/public/?p=post.single&params=<?= $post->getId() ?>&flag=<?= $comment->getId() ?>">Signaler</a>
    </div>
    <?php
    }
    ?>
    <div class="comment box comment-editor">
        <form action="/public/?p=post.comment_submit&params=<?= $post->getId() ?>&comment_submit=true" method="post">
            Nom d'utilisateur : 
            <input class="editor-username" type="text" maxlength="20" name="comment-username">
            <br><br>
            Message :<br>
            <textarea class="autoExpand editor-content" rows='2' name="comment-content"></textarea>
            <input class="editor-submit btn btn-outline-primary" type="submit" value="Commenter">
        </form> 
    </div>
    
</div>
</div>
<?php
require('menu.php');
$content = ob_get_clean();
require('base.php'); ?>