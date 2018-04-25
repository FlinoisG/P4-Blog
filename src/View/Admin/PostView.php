<?php
$title = 'Blog de Jean Forteroche - Administration des articles';
$header = '';
ob_start();
?>
<div class="col-lg-12">
    <h1>Administration</h1>
    <p>Articles</p>
    <a class="btn btn-primary btn-top-editor" href="?p=admin.posteditor">Créer un nouvel article</a>
</div>

<table class="table table-sm table-striped table-dark table-bordered table-hover">
    <thead>
        <tr>
            <th scope="col" class="hidden-sm-down">Titre</th>
            <th scope="col" class="hidden-md-down">Date</th>
            <th scope="col" class="hidden-sm-down">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (sizeof($PostRepository->getPosts()) > 0){
            foreach ($PostRepository->getPosts() as $post) {
                $flaggedComs = 0;
                foreach ($CommentRepository->getComments($post->getId()) as $comment) {
                    if ($comment->getFlagged() != 0){
                        $flaggedComs = $flaggedComs + $comment->getFlagged();
                    }
                }
                if ($flaggedComs != 0){
                    $flaggedComs = '<span class="flag-alert">Attention : ' . $flaggedComs . ' signalement</span>';
                } else {
                    $flaggedComs = '';
                }
                echo '<tr>';
                    echo '<td><a class="adminPostTitle" href="?p=post.single&params=' . $post->getId() . '">' . $post->getTitle() . '</a></td>';
                    echo '<td class="hidden-md-down">' . $post->getDate() . '</td>';
                    ?>
                    <td>
                        <?= $flaggedComs ?> 
                            <a class="btn btn-primary btn-admin" href="?p=admin.comments&id=<?= $post->getId() ?>">Gérer commentaires</a>
                            <a class="btn btn-primary btn-admin" href="?p=admin.posteditor&params=<?= $post->getId() ?>">Éditer</a>
                            <a id="SupprBtn<?= $post->getId() ?>" class="btn btn-danger btn-admin">Supprimer</a>
                    </td>
                    <?php
                echo '</tr>';
                ?>
                <script>
                    var val = "<?= $post->getId() ?>";
                    document.addEventListener('click', function (event) {
                        if (event.target.id == 'SupprBtn<?= $post->getId() ?>'){
                            CommentWindow.init('Confirmer la suppression de l\'article', '?p=admin.post&delete=<?= $post->getId() ?>');
                        }
                    });
                </script>
                <?php
            }
        } else {
            echo '<td colspan="4">Aucun article</td>';
        }
        ?>
    </tbody>
</table>
<script src="assets/js/ConfirmWin.js"></script>

<?php $content = ob_get_clean();
require(dirname(__DIR__).'/base.php');