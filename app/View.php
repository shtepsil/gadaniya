<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 25.10.2021
 * Time: 11:44
 */
namespace app;

class View
{

    /**
     * @param $view_path
     * @param array $params
     */
    public static function render($view_path,$params=[])
    {
        // Вот тут можно было сделать доработки...
        echo self::getContent('layouts/header');
        echo self::getContent($view_path,$params);
        echo self::getContent('layouts/footer');
    }

    /**
     * @param $view_path
     * @param array $params
     * @return string
     */
    public static function getContent($view_path,$params=[])
    {
        if($params){ extract($params); }
        $file = $view_path.'.php';
        ob_start();
        include(ROOT.'/views/'.$file);
        $page_content = ob_get_contents();
        ob_end_clean();
        return $page_content;
    }

}//Class