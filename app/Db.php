<?php

namespace app;

use components\Debugger as d;
use app\exceptions\DbException;

class Db
{

    public static function getConnection()
    {
        $params = Main::$a->params['db'];
        $mysqli = @new \mysqli(
            $params['host'],
            $params['user'],
            $params['password'],
            $params['dbname']
        );
        if($mysqli->connect_errno){
            throw new DbException('Не удалось подключиться к MySQL: '.mysqli_connect_error());
        }else{
            $mysqli->query("SET NAMES 'utf8'");
            return $mysqli;
        }

    }

}//Class
