<?php

namespace App\Entity;

class ConfirmWindow {

    private $color;
    private $message;
    private $action;

    public function __construct($color, $message, $action){
        $this->color = $color;
        $this->message = $message;
        $this->action = $action;
        $notifWindowContent = $this->message;
        $notifWindowColor = $this->color;
        require('../src/View/ConfirmWindowView.php');
    }

    public function setColor($color){
        $this->color = $color;
    }

    public function getColor(){
        return $this->color;
    }

    public function setMessage($message){
        $this->message = $message;
    }

    public function getMessage(){
        return $this->message;
    }

    public function setAction($action){
        $this->action = $action;
    }

    public function getAction(){
        return $this->action;
    }
    
}