<?php ob_start(); ?>
<div class="col-lg-12">
    <?= $content ?>
</div>
<?php 
$content = ob_get_clean();
require('base.php');
