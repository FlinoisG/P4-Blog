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

        <!-- Bootstrap core CSS -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link rel="stylesheet" type="text/css" href="css/base.css">
    </head>

    <body>

    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="/public/?p=post.index"><?= $title ?></a>
        <?php
        
        if (isset($_SESSION['auth'])){
            echo '<a class="btn btn-outline-danger btn-logout" href="/public/?p=post.index&logout=true">Déconnextion</a>';
        }
        ?>
    </nav>

    <main role="main" class="container">
        <div class="row">
            <?= $content ?>
        </div>
    </main>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"></script>
    </body>
</html>