<?php

require_once "vendor/autoload.php";

use App\Controller\PostController;
use App\Controller\DefaultController;
use App\Repository\PostRepository;


if(isset($_GET['p'])){
    $routeTemp = explode('.', $_GET['p']);
    if (count($routeTemp) === 2){
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

$getParams = isset($_GET['params']) ? $_GET['params'] : null;
$postParams = isset($_POST['params']) ? $_POST['params'] : null;
$params = [
    "get" => $getParams,
    "post" => $postParams
];

$controller = "\\App\\Controller\\" . ucfirst($routeTemp['controller']) . "Controller";
if (class_exists($controller, true)){
    $controller = new $controller();
    if (in_array($routeTemp["action"], get_class_methods($controller))){
        call_user_func_array([$controller, $routeTemp["action"]], $params);
    } else {
       
        $content = 'Erreur 404';
        require('base.php');
    }
} else {
    $content = 'Erreur 500';
    require('base.php');
    
}