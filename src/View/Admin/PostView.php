<?php

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
        <?php for ($i = 0; $i < sizeof($PostRepository->getPosts()); $i++){ ?>
            <tr>
                <td><a class="adminPostTitle" href="?p=post.single&params=<?= $postId[$i] ?>"><?= $postTitle[$i] ?></a></td>
                <td class="hidden-md-down"><?= $postDate[$i] ?></td>
                <td>
                    <?= $flaggedComs[$i] ?>
                        <a class="btn btn-primary btn-admin" href="?p=admin.comments&id=<?= $postId[$i] ?>">Gérer commentaires</a>
                        <a class="btn btn-primary btn-admin" href="?p=admin.posteditor&params=<?= $postId[$i] ?>">Éditer</a>
                        <a id="SupprBtn<?= $postId[$i] ?>" class="btn btn-danger btn-admin">Supprimer</a>
                </td>
            </tr>
        <?php } ?>
        <?= $extra ?>
    </tbody>
</table>
<script src="assets/js/ConfirmWin.js"></script>
<script src="assets/js/AdminPostButtons.js"></script>
<?php $content = ob_get_clean();
require(dirname(__DIR__).'/base.php');
