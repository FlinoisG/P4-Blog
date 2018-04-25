<?php

namespace App\Service;

use App\Database\mysqlQuery;

/**
 * Various function related to comments
 */
class CommentService
{

    /**
     * flag a comment as "undesirable"
     *
     * @param int $id Id of the comment to flag
     * @return void
     */
    public function flag($id)
    {
        $mysqlQuery = new mysqlQuery();
        $mysqlQuery->sqlQuery('UPDATE commentaires SET flagged = flagged + 1 WHERE id=' . $id);
    }

    /**
     * remove flag to a comment
     *
     * @param int $id Id of the comment to unflag
     * @return void
     */
    public function removeFlag($id)
    {
        $mysqlQuery = new mysqlQuery();
        $mysqlQuery->sqlQuery('UPDATE commentaires SET flagged = 0 WHERE id=' . $id);
    }
}
