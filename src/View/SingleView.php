<?php ob_start(); ?> 
<div class="col-lg-10" style="text-align: left;">
<div class="box post">
    <div class="row">
        <h2 class="post-titre titre col-lg-8"><?= $post->getTitle() ?></h2>
        <h6 class="post-date col-lg-4"><?= $post->getDate(); ?></h6>
    </div>
    <p class="postContent-single"><?= $post->getContent(); ?></p>
    <p class="comment-header">Commentaires: <?= sizeof($comments) ?></p>
    <?= $content ?>
    <div id="commentbox" class="comment box comment-editor">
        <form action="?p=post.commentSubmit&params=<?= $post->getId() ?>&commentSubmit=true" method="post">
            Nom d'utilisateur : 
            <input class="editor-username" type="text" maxlength="20" name="comment-username">
            <br><br>
            Message :<br>
            <textarea class="autoExpand editor-content" rows='6' name="comment-content"></textarea>
            <input class="editor-submit btn btn-outline-primary" type="submit" value="Commenter">
        </form> 
    </div>
</div>
</div>
<script src="assets/js/ConfirmWin.js"></script>
<?php
require('menu.php');
$content = ob_get_clean();
require('base.php');
