<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 25.10.2021
 * Time: 10:12
 */
namespace app;

use components\Debugger as d;

class Main
{

    public static $a;
    public $router;
    public $params;

    public function __construct($params=[])
    {
        // Настройка приложения
        static::$a = $this;
        $this->params = $params;
        $this->router = new Router();

    }
    public function run()
    {
        // Инициализация приложения
        $this->router->init();
    }

}//Class