<?php 

$title = "Blog de Jean Forteroche - Billet simple pour l'Alaska";
$header = '';
ob_start(); 
?> <div id="postPanel" class="col-lg-10"> <?php
if (sizeof($PostRepository->getPosts()) > 0){
    foreach ($PostRepository->getPosts() as $post) {
        if (strlen($post->getContent()) > 500){
            $content = substr(strip_tags($post->getContent()), 0, 500) . '... <a href="?p=post.single&params=' . $post->getId() . '">lire la suite</a>' ;
        } else {
            $content = strip_tags($post->getContent());
        }
        ?> 
        <div class="box post" style="text-align: left;">
        <div class="row">
            <h2 class="post-titre titre col-lg-9"><a href="?p=post.single&params=<?= $post->getId() ?>"> <?= $post->getTitle() ?></a>
                <p class="index-commentaires">Commentaires: <?php
                $coms = 0;
                foreach ($comments as $comment) {
                    if ($comment->getArticleId() == $post->getId()){
                        $coms++;
                    }
                }
                echo $coms;
                ?></p>
            </h2>
            <h6 class="post-date col-lg-3"><?= $post->getDate(); ?></h6>
        </div>
        <p class="postContent-index"><?= $content ?></p>
        </div>
        <?php
    }
} else {
    ?>
    <div class="box post">
        <h1>Aucun article :/</h1><br>
        <p>Aucun article n'as encore été rédiger.</p>
    </div>
    <?php
}
?>
</div>

<?php 
require('menu.php');

$content = ob_get_clean();

require('base.php'); ?>