<div id="menu" class="col-lg-2 box menu">
    <p>Menu</p>
    <p><a href="?p=post.index">Accueil</a></p>
    <?php
    foreach ($PostRepository->getPosts() as $post) {
        if (isset($_GET['article']) && $_GET['article'] == $post->getId()) {
            echo '<p class="menu-mark" style="text-align: left; font-size: 10px;"><a href="?p=post.single&article='.$post->getId().'">'.$post->getTitle().'</a></p>';
        } else {
            echo '<p style="text-align: left; font-size: 10px;"><a href="?p=post.single&article='.$post->getId().'">'.$post->getTitle().'</a></p>';
        }
    }
    ?>
    <br>
    <br>
    <a id="admin-link" class="admin-link" href="?p=admin.post">Administration</a>   
</div>
