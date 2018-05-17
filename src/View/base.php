<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="favicon.ico">
        <title><?= $title ?></title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/CSS/base.css" rel="stylesheet">
        <?= $header ?>
    </head>
    <body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <a id="title" class="navbar-brand" href="?p=post.index"><?= $title ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            
            <ul class="navbar-nav mr-auto">
            <?php
            $PostRepository = new App\Repository\PostRepository;
            foreach ($PostRepository->getPosts() as $post) {
                echo '<li><a class="menuheader hidden-md-up" href="?p=post.single&params='.$post->getId().'">'.$post->getTitle().'</a></li>';
            }
            ?>
            </ul>
            <?php
            if (isset($_SESSION['auth'])) {
                echo '<a class="btn btn-danger btn-logout" href="?p=post.index&logout=true">Déconnextion</a>';
            }
            ?>
        </div>
    </nav>

    <main role="main" class="container">
        <div class="row">
            <?= $content ?>
        </div>
    </main>
    <footer id="footer">
    </footer>
    
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    </body>
</html>
<script src="assets/js/ShortTitle.js"></script>