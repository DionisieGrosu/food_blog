<?php

namespace core;

use exceptions\wrongControllerException;
use http\Exception;
use function count;
use function debug;
use function explode;
use function preg_match;
use function trim;

/**
 * Class Route
 *
 * Have a couple of methods for
 * creating routes.
 *
 * @package core
 */
class Route
{
    /**
     * @var array $routes
     */
    static protected $routeArray = [];

    /**
     * This method allow us to create routes
     * and connect them with controllers and actions
     *
     * @param String $str
     * @param String|null $controller
     * @param array $params
     * @throws wrongControllerException
     */
    static function get(String $str, String $controller = null, Array $params = [])
    {
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
                    self::$routeArray['get'][trim($str, '/')]['params'][] = trim($param, '{}');
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
//            debug(self::$routeArray);
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
//            debug(self::$routeArray);
//            debug(self::$routeArray);
        }
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