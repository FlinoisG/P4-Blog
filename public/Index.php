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

$getPage = isset($_GET['page']) ? $_GET['page'] : null;
$postPage = isset($_POST['page']) ? $_POST['page'] : null;
$page = [
    "get" => $getPage,
    "post" => $postPage
];
$controller = "\\App\\Controller\\" . ucfirst($routeTemp['controller']) . "Controller";
if (class_exists($controller, true)) {
    $controller = new $controller();
    if (in_array($routeTemp["action"], get_class_methods($controller))) {
        call_user_func_array([$controller, $routeTemp["action"]], $page);
    } else {
        $controller->error('404');
    }
} else {
    $controller = new DefaultController();
    $controller->error('500');
}

$titre = 'Blog de Jean Forteroche';
$header = '';
