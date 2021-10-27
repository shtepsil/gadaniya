<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 25.10.2021
 * Time: 10:53
 */
namespace app;

class Request
{

    /**
     * @return array
     */
    public function request()
    {

        $request = [];
        $uri = self::getUri();
        $level_pos = strripos($uri,'?');
        if($level_pos !== false){
            $request['url'] = explode('/',trim(substr($uri,0,$level_pos), '/'));
        }else{
            if($uri) $request['url'] = explode('/',trim($uri,'/'));
            else $request['url'] = [];
        }
        $get_pos = strpos($uri,'?');
        if($get_pos !== false) $get_query = substr($uri, ($get_pos+1),1);
        else $get_query = false;
        if($get_query){
            $str_get = substr($uri,($get_pos+1));
            if($str_get){
                $get = explode('&',$str_get);
                $arr_get = [];
                foreach($get as $item){
                    $param = explode('=',$item);
                    if($param[0] == '') continue;
                    $arr_get[$param[0]] = $param[1];
                }
                $request['get'] = $arr_get;
            }
        }
        return $request;
    }

    /**
     * @return string
     */
    public static function getUri()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    /**
     * @return bool
     */
    public static function isAjax()
    {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            return true;
        }
        return false;
    }

    /**
     * @param $data
     */
    public static function response($data)
    {
        header('Content-type: text/json');
        header("Content-type: application/json");
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
        exit();
    }

}// Class