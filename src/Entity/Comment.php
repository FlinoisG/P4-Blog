<?php

namespace App\Entity;

class Comment {

    private $id;
    private $username;
    private $content;
    private $date;
    private $articleId;
    private $flagged;

    public function __construct($id, $username, $content, $date, $articleId, $flagged = 0){
        $this->setId($id);
        $this->setUsername($username);
        $this->setContent($content);
        $this->setDate($date);
        $this->setArticleId($articleId);
        $this->setFlagged($flagged);
    }
    
    public function setId($id){
        $this->id = $id;
    }

    public function getId(){
        return $this->id;
    }

    public function setUsername($username){
        $this->username = $username;
    }

    public function getUsername(){
        return $this->username;
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

    public function getDateShort(){
        $time = strtotime($this->date);
        setlocale(LC_ALL, 'fr_FR', 'French_France', 'French_Standard');
        return strftime("%d/%m/%y %H:%M", $time);
    }

    public function setArticleId($articleId){
        $this->articleId = $articleId;
    }

    public function getArticleId(){
        return $this->articleId;
    }

    public function setFlagged($flagged){
        $this->flagged = $flagged;
    }

    public function getFlagged(){
        return $this->flagged;
    }

}