<?php 
$title = 'Blog de Jean Forteroche';
$header = '';
ob_start(); ?>
<div class="col-lg-12">
    <h1>Erreur 500</h1>
    <p>Erreur interne du serveur</p>
</div>
<?php $content = ob_get_clean(); ?>

<?php require(dirname(__DIR__).'/base.php'); ?>