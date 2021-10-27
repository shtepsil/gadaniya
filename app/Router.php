<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 25.10.2021
 * Time: 10:20
 */
namespace app;

use components\Debugger as d;
use app\Request;
use app\exceptions\RouterException;
use components\StringHelper;

class Router
{

    private $routes;

    public function __construct()
    {
        $this->routes = Main::$a->params['routes'];
    }

    public function init()
    {
        $uri = Request::getUri();
        $uri = StringHelper::getPartStrByCharacter($uri,'?','start');
        if(!array_key_exists($uri,$this->routes)){
            throw new RouterException('Маршрут '.$uri.' не найден!');
        }
        foreach ($this->routes as $uriPattern => $path) {
            if (preg_match("~^$uriPattern$~", $uri)) {
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
                if(!OAuth2::checkAuth()){
                    if($internalRoute != 'user/register')
                        $internalRoute = 'user/login';
                }
                $segments = explode('/', $internalRoute);
                $controllerName = ucfirst(array_shift($segments)) . 'Controller';
                $actionName = 'action' . ucfirst(array_shift($segments));
                $parameters = $segments;
                $controllerFile = ROOT . '/controllers/' .$controllerName . '.php';
                if (file_exists($controllerFile)) {
                    include_once($controllerFile);
                }
                $controllerObject = new $controllerName;
                $result = @call_user_func_array(array($controllerObject, $actionName), $parameters);
                if ($result != null) {
                    break;
                }

            }
        }
    }

}//Class
