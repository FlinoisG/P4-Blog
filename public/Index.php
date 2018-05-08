<?php

require_once "../vendor/autoload.php";

use App\Controller\PostController;
use App\Controller\DefaultController;
use App\Repository\PostRepository;

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Refresh:0; url=?p=post.index");
}

if (isset($_GET['p'])) {
    $routeTemp = explode('.', $_GET['p']);
    if (count($routeTemp) === 2) {
        $routeTemp = [
            "controller" => $routeTemp[0],
            "action" => $routeTemp[1]
        ];
    }
} else {
    $routeTemp = [
        "controller" => "",
        "action" => ""
    ];
}

$article = isset($_GET['article']) ? $_GET['article'] : null;
$controller = "\\App\\Controller\\" . ucfirst($routeTemp['controller']) . "Controller";
if (class_exists($controller, true)) {
    $controller = new $controller();
    if (in_array($routeTemp["action"], get_class_methods($controller))) {
        call_user_func([$controller, $routeTemp["action"]], $article);
    } else {
        $controller->error('404');
    }
} else {
    $controller = new DefaultController();
    $controller->error('500');
}

$titre = 'Blog de Jean Forteroche';
$header = '';
