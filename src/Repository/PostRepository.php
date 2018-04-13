<?php

namespace App\Repository;

use App\Database\mysqlQuery;
use App\Entity\Post;
use App\Controller\DefaultController;
use App\Repository\CommentRepository;
use PDO;

/**
 * Store posts from the database and manage them
 */
class PostRepository {

    /**
     * Stores posts from database
     *
     * @var array
     */
    private $posts = [];
    
    /**
     * Get posts from database and store them in $post as Post objects
     *
     * @return void
     */
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

    /**
     * Returns specified id's post
     *
     * @param int $id Return id's post. If not specified, return all posts
     * @return object
     */
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

    /**
     * Delete the specified id's post in the database
     *
     * @param int $id
     * @return void
     */
    public function deletePost($id){
        $mysqlQuery = new mysqlQuery();
        $CommentRepository = new CommentRepository();
        foreach ($CommentRepository->getComments($id) as $comment){
            $mysqlQuery->sqlQuery('DELETE FROM commentaires WHERE id=' . $comment->getId());
        }
        $mysqlQuery->sqlQuery('DELETE FROM articles WHERE id=' . $id);
    }

    /**
     * Submit the provided post into the database
     *
     * @param object $post
     * @return void
     */
    public function submitPost($post){
        $title = str_replace("'", "\'", $post->getTitle());
        $content = str_replace("'", "\'", $post->getContent());
        $mysqlQuery = new mysqlQuery();
        $mysqlQuery->sqlQuery('INSERT INTO articles(title, content) VALUES(
            \'' . htmlspecialchars($title) . '\',
            \'' . $content . '\'
        )');
    }
    /**
     * Update a post in the databse at specified id
     *
     * @param object $post
     * @param int $id
     * @return void
     */
    public function updatePost($post, $id){
        $title = str_replace("'", "\'", $post->getTitle());
        $content = str_replace("'", "\'", $post->getContent());
        $mysqlQuery = new mysqlQuery();
        $mysqlQuery->sqlQuery('UPDATE articles SET title = \''.$title.'\', content = \''.$content.'\' WHERE id='.$id);
    }

}