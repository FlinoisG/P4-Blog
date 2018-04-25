<?php

namespace App\Entity;

class Post {

    private $id;
    private $title;
    private $content;
    private $date;
    private $categoryId;

    public function __construct($id, $title, $content, $date){
        $this->setId($id);
        $this->setTitle($title);
        $this->setContent($content);
        $this->setDate($date);
    }
    
    public function setId($id){
        $this->id = $id;
    }

    public function getId(){
        return $this->id;
    }

    public function setTitle($title){
        $this->title = $title;
    }

    public function getTitle(){
        return $this->title;
    }
    public function setContent($content){
        $this->content = $content;
    }

    public function getContent(){
        return $this->content;
    }
    public function setDate($date){
        $this->date = $date;
    }

    public function getDate(){
        $time = strtotime($this->date);
        setlocale(LC_ALL, 'fr_FR', 'French_France', 'French_Standard');
        return strftime("%A %e %B %Y, %Hh%M", $time);
    }    

}