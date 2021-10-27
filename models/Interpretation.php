<?php

namespace models;

use components\Debugger as d;
use app\Db;

class Interpretation
{

    /**
     * @param $code
     * @return array
     */
    public static function getInterpretation($code)
    {
        $geks_info = [];
        if ($code) {
            $db = Db::getConnection();
            $sql = 'SELECT * FROM `interpretation` WHERE `code` = ?';
            $select = $db->prepare($sql);
            $select->bind_param('s', $code);
            $select->execute();
            $result = $select->get_result();
            if($result->num_rows){
                $geks_info = $result->fetch_assoc();
            }
        }
        return $geks_info;
    }

    /**
     * @return array
     */
    public static function getInterpretations()
    {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM `interpretation`';
        $result = $db->query($sql);

        $geks = [];
        $g_key = 1;// Создам свои ключи. ID могут быть не по порядку.
        if($result->num_rows) {
            while ($row = $result->fetch_assoc()) {
                $geks[$g_key] = $row;
                $g_key++;
            }
        }
        return $geks;
    }

}//Class