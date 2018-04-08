<?php

use App\Entity\Comment;
use App\Entity\NotifWindow;



$title = $post->getTitle() . " - Jean Forteroche, Billet simple pour l'Alaska";
$header = '';
ob_start();

?> 
<div class="col-lg-10" style="text-align: left;">
<div class="box post" style="margin-bottom: 0px;">
    <div class="row">
        <h2 class="post-titre titre col-lg-8"><?= $post->getTitle() ?></h2>
        <h6 class="post-date col-lg-4"><?= $post->getDate(); ?></h6>
    </div>
    <p class="postContent-single"><?= $post->getContent(); ?></p>
</div>
</div>
<?php
require('menu.php');
$content = ob_get_clean();
require('base.php'); ?>