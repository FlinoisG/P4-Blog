<div class="col-lg-2 box">
        <p>Menu</p>
        <p><a href="/public/?p=post.index">Accueil</a></p>
        <?php
        foreach ($PostRepository->getPosts() as $post) {
            echo '<p style="text-align: left; font-size: 10px;"><a href="/commit/P4_Blog/public/?p=post.single&params='.$post->getId().'">'.$post->getTitle().'</a></p>';
        }
        ?>
        <a class="admin-link" href="/commit/P4_Blog/public/?p=admin.post">Administration</a>   
</div>
