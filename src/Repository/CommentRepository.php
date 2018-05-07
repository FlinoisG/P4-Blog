<?php

namespace App\Repository;

use App\Database\mysqlQuery;
use App\Entity\Comment;
use App\Controller\DefaultController;
use App\Controller\DataController;


use PDO;

/**
 * Store comments from the database and manage them
 */
class CommentRepository
{

    /**
     * Stores comments from database
     *
     * @var array
     */
    private $comments = [];
    
    /**
     * Get comments from database and store them in $comments as Comment objects
     * as an array
     *
     * @return void
     */
    public function storeComments($id = null)
    {
        $mysqlQuery = new mysqlQuery();
        $dataController = new DataController();
        $this->comments = [];
        $id = $dataController->queryValidation($id);
        if ($id == null) {
            $arg = '';
        } else {
            $arg = ' WHERE article_id=' . $id;
        }
        $query = 'SELECT * FROM commentaires' . $arg . ' ORDER BY date';
        $commentArray = $mysqlQuery->sqlQuery($query);
        for ($i=0; $i < sizeof($commentArray); $i++) {
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

    public function getComments($id = null)
    {
        $this->storeComments($id);
        return $this->comments;
    }

    public function submitComment($comment)
    {
        $mysqlQuery = new mysqlQuery();
        $dataController = new DataController();
        $content = $dataController->queryValidation($comment->getContent());
        
        $mysqlQuery->sqlQuery('INSERT INTO commentaires(pseudo, content, article_id, date) VALUES(
            \'' . htmlspecialchars($comment->getUsername()) . '\',
            \'' . htmlspecialchars($content) . '\',
            \'' . htmlspecialchars($comment->getArticleId()) . '\',
            \'' . date("Y-m-d H:i:s") . '\'
        )');
    }

    public function deleteComment($id)
    {
        $mysqlQuery = new mysqlQuery();
        $dataController = new DataController();
        $id = $dataController->queryValidation($id);
        $mysqlQuery->sqlQuery('DELETE FROM commentaires WHERE id=' . $id);
    }
}
