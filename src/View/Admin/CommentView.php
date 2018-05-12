<?php 
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
            <th scope="col" class="hidden-sm-down">Pseudo</th>
            <th scope="col" class="hidden-sm-down">Contenu</th>
            <th scope="col" class="hidden-sm-down">Date</th>
            <th scope="col" class="hidden-sm-down">Signalement</th>
            <th scope="col" class="hidden-sm-down">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if (isset($username)) {
            var_dump($commentId);
            for ($i = 0; $i < count($username); $i++) { ?>
                <tr>
                    <td><?= $username[$i] ?></td>
                    <?= $contentLength[$i] ?>
                    <td class="hidden-sm-down"><?= $dateShort[$i] ?></td>
                    <?= $flagged[$i] ?>
                    <td>
                        <a class="btn btn-primary btn-admin-com" href="?p=admin.comments&id=<?= $articleId[$i] ?>&deleteFlag=<?= $commentId[$i] ?>">Enlever signalements</a>
                        <a id="SupprBtn<?= $commentId[$i] ?>" class="btn btn-danger btn-admin-com">Supprimer</a>
                    </td>
                </tr>
                <script type="text/javascript">
                    var commentId = "<?= $commentId[$i] ?>";
                    var articleId = "<?= $articleId[$i] ?>";
                    var commentContentShort = "<?= $commentContentShort[$i] ?>";
                    var commentContentExpanded = "<?= $commentContentExpanded[$i] ?>";
                </script>
                <script language="JavaScript" src="assets/js/ShortTextButton.js" type="text/javascript"></script>
        <?php 
            }
        } else { ?>
            <td colspan="5">Aucun commentaire</td> <?php
        } ?>
    </tbody>
</table>
<script src="assets/js/ConfirmWin.js"></script>
<?php 
$content = ob_get_clean();
require(dirname(__DIR__).'/base.php');
