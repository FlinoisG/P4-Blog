<?php
$title = 'Blog de Jean Forteroche - Administration des articles';
$header = '';
ob_start();
?>
<div class="col-lg-12">
    <h1>Administration</h1>
    <p>Articles</p>
</div>

<table class="table table-sm table-striped table-dark table-bordered table-hover">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Titre</th>
            <th scope="col">Date</th>
            <th scope="col">Actions</th>
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
                    echo '<td>' . $post->getId() . '</td>';
                    echo '<td><a href="/public/?p=post.single&params=' . $post->getId() . '">' . $post->getTitle() . '</a></td>';
                    echo '<td>' . $post->getDate() . '</td>';
                    ?>
                    <td>
                        <?= $flaggedComs ?> 
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a class="btn btn-primary btn-admin" href="/public/?p=admin.comments&id=<?= $post->getId() ?>">Gérer commentaires</a>
                            <a class="btn btn-primary btn-admin" href="/public/?p=admin.posteditor&params=<?= $post->getId() ?>">Éditer</a>
                            <a id="SupprBtn<?= $post->getId() ?>" class="btn btn-danger btn-admin">Supprimer</a>
                        </div>
                    </td>
                    <?php
                echo '</tr>';
                ?>
                <script>
                    var val = "<?= $post->getId() ?>";
                    document.addEventListener('click', function (event) {
                        if (event.target.id == 'SupprBtn<?= $post->getId() ?>'){
                            console.log('<?= $post->getId() ?>');
                            CommentWindow.init('Confirmer la suppression de l\'article', '/public/?p=admin.post&delete=<?= $post->getId() ?>', '<?= $post->getId() ?>');
                            //
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
<script src="/src/View/Admin/CommentWindow.js"></script>
<?php 
$content = ob_get_clean(); ?>
<?php require(dirname(__DIR__).'/base.php'); ?>