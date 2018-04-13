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
        <link href="assets/CSS/base.css" rel="stylesheet">
        <?= $header ?>
    </head>

    <body>

    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <a id="title" class="navbar-brand" href="/public/?p=post.index"><?= $title ?></a>
        <?php
        
        if (isset($_SESSION['auth'])){
            echo '<a class="btn btn-danger btn-logout" href="/public/?p=post.index&logout=true">Déconnextion</a>';
        }
        ?>
    </nav>

    <main role="main" class="container">
        <div class="row">
            <?= $content ?>
        </div>
    </main>
    <footer id="footer">
    </footer>
    <script>
        function myFunction(x) {
            if (x.matches) {
                document.getElementById('footer').appendChild(
                    document.getElementById('admin-link')
                );
                document.getElementById('title').textContent = "Blog de Jean Forteroche";
                
            } else {
                document.getElementById('menu').appendChild(
                    document.getElementById('admin-link')
                );
                document.getElementById('title').textContent = "<?= $title ?>";
            }
        }
        var x = window.matchMedia("(max-width: 1000px)")
        myFunction(x)
        x.addListener(myFunction)
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"></script>
    </body>
</html>