<?php

namespace core;

use exceptions\wrongControllerException;
use http\Exception;
use function count;
use function debug;
use function explode;
use function preg_match;
use function strtolower;
use function trim;

/**
 * Class Route
 *
 * The route class has several methods for
 * creating routes.
 *
 * @package core
 */
class Route
{
    /**
     * @var array $routes
     */
    static private $routeArray = [];

    /**
     * This get method allow us to create routes
     * and connect them with controllers and actions.
     * Method works only with get request.
     *
     * @param String $str
     * @param String|null $controller
     * @param array $params
     * @throws wrongControllerException
     */
    static function get(String $str, String $controller = null, Array $params = [])
    {

        if (strtolower($_SERVER['REQUEST_METHOD']) == 'get') {
            if (!$controller) {
                if (count(explode('/', trim($str, '/'))) == 2) {
                    $arrController = explode('/', trim($str, '/'));
                    self::$routeArray['get'][trim($str, '/')] = ['controller' => $arrController[0], 'action' => $arrController[1],
                        'params' => []];
                    if ($params) {
                        self::$routeArray['get'][trim($str, '/')]['params'] = $params;
                    }
//                debug(self::$routeArray);
                } else {
                    throw new wrongControllerException('Wrong path name!!! You should type the "controllerName/actionName"');
                }
            } else {
                if (preg_match('/@/', $controller)) {
                    $arrController = explode('@', $controller);
                    self::$routeArray['get'][trim($str, '/')] = ['controller' => $arrController[0], 'action' => $arrController[1],
                        'params' => []];


                } else {
                    throw new wrongControllerException('Wrong controller! You should type "controllerName@actionName"!!!');
                }


                if (preg_match_all('/{\\w*}/', $str, $matches)) {
//            echo trim($matches[0][1],'{}');
                    foreach ($matches[0] as $param) {
                        eAself::$routrray['get'][trim($str, '/')]['params'][] = trim($param, '{}');
                    }
//            for($i = 0; $i < count($str);){
//
//            }
//            strpos($str,'{');

                } else {
                    if (count($params) > 0) {
                        self::$routeArray['get'][trim($str, '/')]['params'] = $params;
                    }
                }
            }

            //In this section we loading controller;
            $path = preg_match('/\\?/', $_SERVER['REQUEST_URI']) ? trim(substr($_SERVER['REQUEST_URI'], 0, strrpos($_SERVER['REQUEST_URI'], '?')), '/') : trim($_SERVER['REQUEST_URI'], '/');
            $array = [];
            $pathArray = explode('/', $path);
//            debug(self::$routeArray);
            foreach (self::$routeArray as $key => $value) {
                if ($key == 'get') {
//                        echo 'get';
                    foreach (self::$routeArray[$key] as $route => $values) {
//                        if (preg_match('/' . $pathArray[0] . '/', $route)) {
//                            $array[$route] = $values;
//                        }
//                        echo $route;
//                        echo $pathArray[0];
                        if (count(explode('/', $route)) == count($pathArray)) {
                            $array[$route] = $values;

                        }
//                        echo count(explode('/', $route)) . '</br>';
//                        echo count($pathArray) . '</br>';
//                            debug($array);
                    }
//                    debug($array);
//                    echo $path;
                    foreach ($array as $route => $values) {
                        if ($path == $route) {
                            $controller = $array[$route]['controller'];
//                                echo $path;
//                                echo $route;
                            $action = $array[$route]['action'];
//                                echo $action;
                            if (file_exists('Controllers/' . $controller . '.php')) {
//                                require_once "Controllers/" . $controller . ".php";
//                                require 'Controllers/MainController.php';
                                $controller = 'controllers\\' . $controller;
                                $controllerClass = new $controller();
                                $request = null;
                                if (count($values['params']) != 0) {
                                    $request = new Request($values['params'], 'get');

                                }

                                if (method_exists($controllerClass, $action)) {
//                                    echo 'Hello';
                                    if ($request != null) {
//                                        echo 'hello';
                                        $controllerClass->$action($request);
                                    } else {
                                        $controllerClass->$action();
                                    }

                                }

                            } else {
                                throw new wrongControllerException($controller . ' don\'t exist');
                            }
                            unset(self::$routeArray[$key][$route]);
                            break;
                        } else {
//                                echo 'hello';
//                            echo $path . '</br>';
//                            echo $route;
                            if (preg_match_all('/{\\w*}/', $route, $matches)) {
                                $routeArray = explode('/', $route);
                                $pathArray = explode('/', $path);
                                $paramsArray = [];
//                                debug($routeArray);
                                foreach ($routeArray as $key => $elem) {
                                    if (preg_match('/{\\w*}/', $elem, $matches)) {
//                                        echo trim($elem, '{}') . ' ';
                                        $paramsArray[trim($elem, '{}')] = $pathArray[$key];
                                    }
                                }
                                $controller = $array[$route]['controller'];
                                $action = $array[$route]['action'];
                                if (file_exists('Controllers/' . $controller . '.php')) {
                                    $controller = 'controllers\\' . $controller;
                                    $controllerClass = new $controller();
                                    $request = null;
                                    if (count($paramsArray) != 0) {
                                        $request = new Request($paramsArray, 'get');
                                    }
                                    if (method_exists($controllerClass, $action)) {
//                                    echo 'Hello';
                                        if ($request != null) {
//                                        echo 'hello';
                                            $controllerClass->$action($request);
                                        } else {
                                            $controllerClass->$action();
                                        }

                                    }
                                }
                                unset(self::$routeArray[$key][$route]);
                                break;
                            }

                        }
                    }
                }

            }

        }

////        $arrPath = explode('/',$str);
//        if ($controller != false) {
//            $arrController = explode('@', $controller);
//            self::$routeArray['get'][$str] = ['controller' => $arrController[0], 'action' => $arrController[1],
//                'params' => []];
//        }
////        $getArray[] = $str;
////        debug($routeArray);
//        if (preg_match_all('/{\\w*}/', $str, $matches)) {
////            echo trim($matches[0][1],'{}');
//            foreach ($matches[0] as $param) {
//                self::$routeArray['get'][$str]['params'][] = trim($param, '{}');
//            }
////            for($i = 0; $i < count($str);){
////
////            }
////            strpos($str,'{');
//
//        }else{
//            if(count($params) > 0){
//                self::$routeArray['get'][$str]['params'] = $params;
//            }
//        }
////        debug(self::$routeArray);
////        self::loadController();
////          self::loadController();
////        self::loadController();

    }

    static function post($str, $controller = '', $params = [])
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!$controller) {
                if (count(explode('/', trim($str, '/'))) == 2) {
                    $arrController = explode('/', trim($str, '/'));
                    self::$routeArray['post'][trim($str, '/')] = ['controller' => $arrController[0], 'action' => $arrController[1],
                        'params' => []];
                    if ($params) {
                        self::$routeArray['post'][trim($str, '/')]['params'] = $params;
                    }
//                debug(self::$routeArray);
                } else {
                    throw new wrongControllerException('Wrong path name!!! You should type the "controllerName/actionName"');
                }
            } else {
                if (preg_match('/@/', $controller)) {
                    $arrController = explode('@', $controller);
                    self::$routeArray['post'][trim($str, '/')] = ['controller' => $arrController[0], 'action' => $arrController[1],
                        'params' => []];


                } else {
                    throw new wrongControllerException('Wrong controller! You should type "controllerName@actionName"!!!');
                }


                if (preg_match_all('/{\\w*}/', $str, $matches)) {
//            echo trim($matches[0][1],'{}');
                    foreach ($matches[0] as $param) {
                        self::$routeArray['post'][trim($str, '/')]['params'][] = trim($param, '{}');
                    }
//            for($i = 0; $i < count($str);){
//
//            }
//            strpos($str,'{');

                } else {
                    if (count($params) > 0) {
                        self::$routeArray['post'][trim($str, '/')]['params'] = $params;
                    }
                }

                //In this section we loading controller;
                $path = preg_match('/\\?/', $_SERVER['REQUEST_URI']) ? trim(substr($_SERVER['REQUEST_URI'], 0, strrpos($_SERVER['REQUEST_URI'], '?')), '/') : trim($_SERVER['REQUEST_URI'], '/');
                $array = [];
                $pathArray = explode('/', $path);

                foreach (self::$routeArray as $key => $value) {
                    if ($key == 'post') {
                        foreach (self::$routeArray[$key] as $route => $values) {
//                        if (preg_match('/' . $pathArray[0] . '/', $route)) {
//                            $array[$route] = $values;
//                        }
//                        echo $route;
//                        echo $pathArray[0];
                            if (count(explode('/', $route)) == count($pathArray)) {
                                $array[$route] = $values;

                            }
//                        echo count(explode('/', $route)) . '</br>';
//                        echo count($pathArray) . '</br>';
                        }
                        foreach ($array as $route => $values) {
                            if ($path == $route) {
                                $controller = $array[$route]['controller'];
                                $action = $array[$route]['action'];
                                if (file_exists('Controllers/' . $controller . '.php')) {
//                                require_once "Controllers/" . $controller . ".php";
//                                require 'Controllers/MainController.php';
                                    $controller = 'controllers\\' . $controller;
                                    $controllerClass = new $controller();
                                    $request = null;
                                    if (count($values['params']) != 0) {
                                        $request = new Request($values['params'], 'post');
                                    }

                                    if (method_exists($controllerClass, $action)) {
//                                    echo 'Hello';
                                        if ($request != null) {
//                                        echo 'hello';
                                            $controllerClass->$action($request);
                                        } else {
                                            $controllerClass->$action();
                                        }

                                    }

                                } else {
                                    throw new wrongControllerException($controller . ' don\'t exist');
                                }

                                break;
                            } else {
//                            echo 'hello';
//                            echo $path . '</br>';
//                            echo $route;
                                if (preg_match_all('/{\\w*}/', $route, $matches)) {
//                                echo 'hello';
                                    $routeArray = explode('/', $route);
                                    $pathArray = explode('/', $path);
                                    $paramsArray = [];
//                                debug($routeArray);
                                    foreach ($routeArray as $key => $elem) {
                                        if (preg_match('/{\\w*}/', $elem, $matches)) {
//                                        echo trim($elem, '{}') . ' ';
                                            $paramsArray[trim($elem, '{}')] = $pathArray[$key];
                                        }
                                    }
                                    $controller = $array[$route]['controller'];
                                    $action = $array[$route]['action'];
                                    if (file_exists('Controllers/' . $controller . '.php')) {
                                        $controller = 'controllers\\' . $controller;
                                        $controllerClass = new $controller();
                                        $request = null;
                                        if (count($paramsArray) != 0) {
                                            $request = new Request($paramsArray);
                                        }
                                        if (method_exists($controllerClass, $action)) {
//                                    echo 'Hello';
                                            if ($request != null) {
//                                        echo 'hello';
                                                $controllerClass->$action($request);
                                            } else {
                                                $controllerClass->$action();
                                            }

                                        }
                                    }
                                    break;
                                }
                            }
                        }
                    }

                }
            }
        }
//        if (!$controller) {
//            if (count(explode('/', trim($str, '/'))) == 2) {
//                $arrController = explode('/', trim($str, '/'));
//                self::$routeArray['post'][trim($str, '/')] = ['controller' => $arrController[0], 'action' => $arrController[1],
//                    'params' => []];
//                if ($params) {
//                    self::$routeArray['post'][trim($str, '/')]['params'] = $params;
//                }
////                debug(self::$routeArray);
//            } else {
//                throw new wrongControllerException('Wrong path name!!! You should type the "controllerName/actionName"');
//            }
//        } else {
//            if (preg_match('/@/', $controller)) {
//                $arrController = explode('@', $controller);
//                self::$routeArray['post'][trim($str, '/')] = ['controller' => $arrController[0], 'action' => $arrController[1],
//                    'params' => []];
//
//
//            } else {
//                throw new wrongControllerException('Wrong controller! You should type "controllerName@actionName"!!!');
//            }
//
//
//            if (preg_match_all('/{\\w*}/', $str, $matches)) {
////            echo trim($matches[0][1],'{}');
//                foreach ($matches[0] as $param) {
//                    self::$routeArray['post'][trim($str, '/')]['params'][] = trim($param, '{}');
//                }
////            for($i = 0; $i < count($str);){
////
////            }
////            strpos($str,'{');
//
//            } else {
//                if (count($params) > 0) {
//                    self::$routeArray['post'][trim($str, '/')]['params'] = $params;
//                }
//            }
////            debug(self::$routeArray);
////            debug(self::$routeArray);
//        }
//        if ($controller != false) {
//            $arrController = explode('@', $controller);
//            self::$routeArray['post'][$str] = ['controller' => $arrController[0], 'action' => $arrController[1],
//                'params' => []];
//        }
////        $getArray[] = $str;
////        debug($routeArray);
//        if (preg_match_all('/{\\w*}/', $str, $matches)) {
////            echo trim($matches[0],'{}');
////            debug($matches);
//            foreach ($matches[0] as $param) {
//                self::$routeArray['post'][$str]['params'][] = trim($param, '{}');
//            }
////            for($i = 0; $i < count($str);){
////
////            }
////            strpos($str,'{');
//
//        } else {
//            if (count($params) > 0) {
//                self::$routeArray['post'][$str]['params'] = $params;
//            }
//        }
//        debug(self::$routeArray);
//        self::loadController();

    }

//    static private function loadController()
//    {
//        $path = trim($_SERVER['REQUEST_URI'], '/');
////        foreach (self::$routeArray as $methods => $routes) {
//////            if(preg_match('/^'.$path.'$/',$route)){
//////                echo 'Right path';
//////            }
////            foreach ($routes as $route => $value){
////                debug($route);
////            }
////
////        }
//        debug(self::$routeArray);
//
//    }


}



//    protected $routes = [];
//    protected $route = [];
//    protected $params = [];
//
//    /**
//     * Router constructor.
//     */
//    function __construct(){
//        $routesFile = 'config/routes.php';
//        if(file_exists($routesFile)){
//            $arr = require $routesFile;
////            debug($arr);
//            foreach($arr as $key => $value){
//                $path = '#^'.$key.'$#';
//                $this->routes[] = $path;
//                $this->params[$path] = $value;
//            }
////            debug($this->params);
////            echo $this->match($_SERVER['REQUEST_URI']);
////            debug($_SERVER['REQUEST_URI']);
//            $this->run();
//
//        }else{
//            echo 'Did not was found file routes';
//        }
//
//
//    }
//
//    /**
//     * Match the path, what was typed in head line.
//     *
//     * @param string $url
//     *
//     * @return string|bool
//     */
//    function match($url){
//        $path = '';
//        foreach ($this->routes as $route) {
//            if(preg_match($route,trim($url,'/'))){
//                $path =  $url;
//                return $path;
//            }
//        }
//        return false;
//    }
//
//
//    function run(){
//        if ($this->match($_SERVER['REQUEST_URI'])){
//            $controller = 'Controllers'.$this->match($_SERVER['REQUEST_URI']).'.php';
//            echo $controller;
//        }
//    }
//}