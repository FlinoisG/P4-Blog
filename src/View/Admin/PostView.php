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
    </tbody>
</table>
<script src="/src/View/Admin/CommentWindow.js"></script>
<?php 
$content = ob_get_clean(); ?>
<?php require(dirname(__DIR__).'/base.php'); ?>