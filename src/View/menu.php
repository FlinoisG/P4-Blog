<div id="menu" class="col-lg-2 box menu">
        <p>Menu</p>
        <p><a href="/public/?p=post.index">Accueil</a></p>
        <?php
        foreach ($PostRepository->getPosts() as $post) {
            echo '<p style="text-align: left; font-size: 10px;"><a href="/public/?p=post.single&params='.$post->getId().'">'.$post->getTitle().'</a></p>';
        }
        ?>
        <a id="admin-link" class="admin-link" href="/public/?p=admin.post">Administration</a>   
</div>
