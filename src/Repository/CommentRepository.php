<?php

namespace App\Repository;

use App\Database\mysqlQuery;
use App\Entity\Comment;
use App\Controller\DefaultController;


use PDO;

class CommentRepository {

    private $comments = [];
    
    public function storeComments($id = NULL){
        $this->comments = [];
        $mysqlQuery = new mysqlQuery();
        if ($id == NULL){
            $arg = '';
        } else {
            $arg = ' WHERE article_id=' . $id;
        }
        $query = 'SELECT * FROM commentaires' . $arg;
        $commentArray = $mysqlQuery->sqlQuery($query);
        for ($i=0; $i < sizeof($commentArray); $i++){
            $this->comments[$i] = new Comment(
                $commentArray[$i]["id"],
                $commentArray[$i]["pseudo"],
                $commentArray[$i]["content"],
                $commentArray[$i]["date"],
                $commentArray[$i]["article_id"],
                $commentArray[$i]["flagged"]
            );
        }
    }

    public function getComments($id = NULL){
        $this->storeComments($id);
        return $this->comments;
    }

    public function submitComment($comment){
        $content = str_replace("'", "''", $comment->getContent());
        $mysqlQuery = new mysqlQuery();
        $mysqlQuery->sqlQuery('INSERT INTO commentaires(pseudo, content, article_id) VALUES(
            \'' . htmlspecialchars($comment->getUsername()) . '\',
            \'' . htmlspecialchars($content) . '\',
            \'' . htmlspecialchars($comment->getArticleId()) . '\'
        )');
    }

    public function deleteComment($id){
        $mysqlQuery = new mysqlQuery();
        $mysqlQuery->sqlQuery('DELETE FROM commentaires WHERE id=' . $id);
    }

}