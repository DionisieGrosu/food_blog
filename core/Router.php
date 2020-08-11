<?php


namespace core;

require 'Route.php';
require 'Request.php';


use exceptions\wrongControllerException;
use controllers\FoodController;
use function debug;

/**
 * Class Router
 * @package core
 */
class Router extends Route
{

    /**
     * Router constructor.
     */
    public function __construct()
    {
//        Route::get('admin/index');
        try {
//            Route::get('admin/foods', null, ['id', 'name']);
            Route::get('/', 'MainController@index', ['id', 'name']);
            Route::get('food', 'FoodController@index', ['id', 'name']);
//            Route::get('foods/{page}', 'FoodsController@index');
//            Route::get('foods/{page}/{type}', 'FoodsController@showTypeOfFood');
//            Route::get('about', 'AboutController@index');
//            Route::get('admin/{name}', 'AdminController@index');
//            Route::get('admin/food', null, ['id', 'name']);
        } catch (wrongControllerException $e) {
            $e->show();
//            echo $e->getTraceAsString();
//            throw $e;
        }

//        Router::post('admin/login', 'AdminController@login');
    }

    function loadController()
    {
        if (strtolower($_SERVER['REQUEST_METHOD']) == 'get') {
            $path = trim(substr($_SERVER['REQUEST_URI'], 0, strrpos($_SERVER['REQUEST_URI'], '?')), '/');
            $array = [];
            $pathArray = explode('/', $path);
            foreach (self::$routeArray as $key => $value) {
                if ($key == 'get') {
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
                                    $request = new Request($values['params']);
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

                        } else {
                            if (preg_match_all('/{\\w*}/', $route, $matches)) {
                                $routeArray = explode('/', $route);
                                foreach ($routeArray as $elem) {
                                    if (preg_match('/{\\w*}/', $elem, $matches)) {
                                        echo trim($elem, '{}') . ' ';

                                    }
                                }
                            }
                        }
                    }
                }

            }
//            self::$routeArray
        } else {
            echo 'Method post';
        }
//        $path = trim(substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], '?')), '/');
//        $arrayController = [];
//        foreach (self::$routeArray as $methods => $routes) {
////            if(preg_match('/^'.$path.'$/',$route)){
////                echo 'Right path';
////            }
////            debug($routes);
//            foreach ($routes as $route => $value) {
//                if (preg_match('#' . $path . '#', $route)) {
//                    $arrayController[$methods][] = $value[''];
//                }
////                echo $path;
////                debug($route);
//            }
//
//        }
//        debug(parent::$routeArray);

    }
}