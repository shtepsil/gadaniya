<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 27.10.2021
 * Time: 11:29
 */

namespace components;

class StringHelper
{

    public static function getPartStrByCharacter($url,$haracter,$code = false)
    {

        switch($code){
            case 'start':
                $pos = strpos($url, $haracter);
                if($pos != '') $str = substr($url, 0, $pos);
                else $str = $url;
                break;
            case 'last':
                $pos = mb_strripos($url, $haracter);
                if($pos != '') $str = substr($url, 0, $pos);
                else $str = $url;
                break;
            case 'all_from_first':
                $pos = strpos($url, $haracter);
                if($pos != '') $str = substr($url, $pos+1);
                else $str = $url;
                break;
            default:
                $revstr = strrev($url);
                $position = strpos($revstr, $haracter);
                $str_itog_rev = substr($revstr,0,$position);
                $str = strrev($str_itog_rev);
        }

        return $str;

    }// function getPartStrByCharacter(...)

}//Class