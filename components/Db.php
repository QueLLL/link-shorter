<?php

namespace Components;

class Db
{

    public static function getConnection()
    {
       require  __DIR__. "/../configs/config.php";
        return new \PDO($dsn, $user, $password);
    }

}