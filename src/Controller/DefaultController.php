<?php

namespace App\Controller;

/**
 * Default controller from which all controllers will extends
 */
class DefaultController
{

    /**
     * @param string $error HTTP status code
     * @return void
     */
    public function error($error)
    {
        $errorF = '../src/View/Error/' . $error . 'View.php';
        if (file_exists($errorF)) {
            require('../src/View/Error/' . $error . 'View.php');
        } else {
            require('../src/View/Error/500View.php');
        }
    }

    /**
     * if $_GET['article'] is not set, die with a 404 error
     *
     * @return void
     */
    public function checkArticle()
    {
        if (!isset($_GET['article'])) {
            die($this->error('404'));
        } else {
            $id = $_GET['article'];
        }
    }
}
