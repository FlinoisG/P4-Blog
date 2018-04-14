<?php 
$title = 'Blog de Jean Forteroche - Administration des commentaires';
$header = '';
ob_start();
?>
<div class="col-lg-12">
    <h1>Administration</h1>
    <p>Commentaires</p>
    <a class="btn btn-primary btn-top-editor" href="?p=admin.post">Retour</a>
</div>
<table class="table table-sm table-striped table-dark table-bordered table-hover">
    <thead>
        <tr>
            <th scope="col">Pseudo</th>
            <th scope="col">Contenu</th>
            <th scope="col">Date</th>
            <th scope="col">Signalement</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (sizeof($CommentRepository->getComments()) > 0){
            foreach ($CommentRepository->getComments($id) as $comment) {
                if (strlen($comment->getContent()) > 70){
                    $content = substr($comment->getContent(), 0, 70) . '... <a href="?p=post.single&params=' . $comment->getArticleId() . '&highlight=' . $comment->getId() . '#' . $comment->getId() . '">lire la suite</a>' ;
                } else {
                    $content = $comment->getContent();
                }
                $flagged;
                if ($comment->getFlagged() != 0){
                    $flagged = '<td style="color: red;">' . $comment->getFlagged() . '</td>';
                } else {
                    $flagged = '<td>0</td>';
                }
                echo '<tr>';
                    echo '<td>' . $comment->getUsername() . '</td>';
                    echo '<td>' . $content . '</td>';
                    echo '<td>' . $comment->getDateShort() . '</td>';
                    echo $flagged;
                    echo '<td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a class="btn btn-primary btn-admin-com" href="?p=admin.comments&id=' . $comment->getArticleId() . '&deleteFlag=' . $comment->getId() . '">Enlever signalements</a>
                            <a id="SupprBtn' . $comment->getId() . '" class="btn btn-danger btn-admin-com">Supprimer</a>
                        </div>
                    </td>';
                echo '</tr>';
                ?>
                <script>
                    var val = "<?= $comment->getId() ?>";
                    document.addEventListener('click', function (event) {
                        if (event.target.id == 'SupprBtn<?= $comment->getId() ?>'){
                            console.log('<?= $comment->getId() ?>');
                            CommentWindow.init('Confirmer la suppression du commentaire', '?p=admin.comments&id=<?= $comment->getArticleId() ?>&delete=<?= $comment->getId() ?>');
                        }
                    });
                </script>
                <?php
            }
        } else {
            echo '<td colspan="5">Aucun commentaire</td>';
        }
        ?>
    </tbody>
</table>
<script src="assets/js/ConfirmWin.js"></script>
<?php 
$content = ob_get_clean(); ?>
<?php require(dirname(__DIR__).'/base.php'); ?>