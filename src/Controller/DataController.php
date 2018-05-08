<?php

namespace App\Controller;

/**
 * Miscellaneous function to handle data
 */
class DataController extends DefaultController
{

    /**
     * Check the provided query if it is safe to enter in the database
     *
     * @param string $query
     * @return string
     */
    public function queryValidation($query)
    {
        $bannedCommands = [
            "select",
            "update",
            "delete",
            "insert into",
            "create database",
            "alter database",
            "create table",
            "alter table",
            "drop table",
            "create index",
            "drop index"
        ];
        $validate = true;
        for ($i = 0; $i < count($bannedCommands); $i++) {
            if (strpos(strtolower($query), $bannedCommands[$i])) {
                $validated = false;
            }
        }
        $query = str_replace("'", "\\'", $query);
        $query = str_replace('"', '\\"', $query);
        if (!$validate) {
            die($this->error("403"));
        } else {
            return $query;
        }
    }

}
