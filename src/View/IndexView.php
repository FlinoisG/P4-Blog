<?php ob_start(); ?> 
<div id="postPanel" class="col-lg-10">
    <?= $posts ?>
</div>
<?php 
require('menu.php');
$content = ob_get_clean();
require('base.php');