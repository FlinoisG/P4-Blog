<?php

namespace App\Repository;

use App\Database\mysqlQuery;
use App\Entity\Post;
use App\Controller\DefaultController;
use App\Repository\CommentRepository;
use PDO;

class PostRepository {

    private $posts = [];
    
    public function storePosts(){
        $this->posts = [];
        $mysqlQuery = new mysqlQuery();
        $postArray = $mysqlQuery->sqlQuery('SELECT * FROM articles ORDER BY date');
        for ($i=0; $i < sizeof($postArray); $i++){
            $this->posts[$i] = new Post(
                $postArray[$i]["id"],
                $postArray[$i]["title"],
                $postArray[$i]["content"],
                $postArray[$i]["date"]
            );
        }
    }

    public function getPosts($id = NULL){
        if ($this->posts == []){
            $this->storePosts();
        }
        if ($id != NULL){
            foreach ($this->posts as $post) {
                if ($post->getId() == $id){
                    return $post;
                    break;
               }
            }
        } else {
            return $this->posts;
        }
    }

    public function deletePost($id){
        $mysqlQuery = new mysqlQuery();
        $CommentRepository = new CommentRepository();
        foreach ($CommentRepository->getComments($id) as $comment){
            $mysqlQuery->sqlQuery('DELETE FROM commentaires WHERE id=' . $comment->getId());
        }
        $mysqlQuery->sqlQuery('DELETE FROM articles WHERE id=' . $id);
    }

    public function submitPost($post){
        $title = str_replace("'", "\'", $post->getTitle());
        $content = str_replace("'", "\'", $post->getContent());
        $mysqlQuery = new mysqlQuery();
        $mysqlQuery->sqlQuery('INSERT INTO articles(title, content) VALUES(
            \'' . htmlspecialchars($title) . '\',
            \'' . $content . '\'
        )');
    }

    public function updatePost($post, $id){
        $title = str_replace("'", "\'", $post->getTitle());
        $content = str_replace("'", "\'", $post->getContent());
        $mysqlQuery = new mysqlQuery();
        $mysqlQuery->sqlQuery('UPDATE articles SET title = \''.$title.'\', content = \''.$content.'\' WHERE id='.$id);
    }

}