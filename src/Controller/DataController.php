<?php

namespace App\Controller;

class DataController extends DefaultController
{

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
        for ($i = 0; $i < count($bannedCommands); $i++){
            if (strpos(strtolower($query), $bannedCommands[$i])) {
                $validated = false;
            }
        }
        $query = str_replace("'", "\\'", $query);
        $query = str_replace('"', '\\"', $query);
        //$query = htmlspecialchars($query);
        if (!$validate){
            die($this->error("403"));
        } else {
            return $query;
        }
    }
}