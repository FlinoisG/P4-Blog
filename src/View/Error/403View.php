<?php 
$title = 'Blog de Jean Forteroche';
$header = '';
ob_start(); ?>
<div class="col-lg-12">
    <h1>Erreur 403</h1>
    <p>Accès refusé</p>
</div>
<?php 
$content = ob_get_clean();
$path = dirname(__DIR__).'/base.php';
require($path);
