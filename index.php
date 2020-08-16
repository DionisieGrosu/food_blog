<?php

require 'core/Dev.php';

use core\Model;
use exceptions\wrongControllerException;

require 'core/Router.php';
require 'core/Controller.php';
require 'Controllers/MainController.php';


//set_include_path(implode(PATH_SEPARATOR, array(get_include_path(), './core', './Controllers', './Models', './Exceptions')));

//function autoloadExceptions($class)
//{
//    #require the general classes
//    $file = 'Exceptions/' . $class . '.php';
//    if (file_exists($file))
//        require $file;
//}
//
//function autoloadModels($class)
//{
//    #require the models classes
//    $file = 'Models/' . $class . '.php';
//    if (file_exists($file))
//        require $file;
//}
//
//function autoloadControllers($class)
//{
//    #require the controllers classes
//    $file = 'Controllers/' . $class . '.php';
//    if (file_exists($file))
//        require $file;
//}

//
//function autoloadCore($class)
//{
//    #require the controllers classes
//    $file = '' . $class . '.php';
//    if (file_exists($file))
//        require $file;
//}


//spl_autoload_register('autoloadExceptions');
//spl_autoload_register('autoloadControllers');
//spl_autoload_register('autoloadModels');
//spl_autoload_register('autoloadCore');
spl_autoload_register(function ($fileName) {
    if (file_exists($fileName . '.php')) {
        require $fileName . '.php';
    }


});

//require 'Exceptions/wrongControllerException.php';
//Router::get('admin/foods/{user}', 'FoodsController@index');
//Router::post('admin/foods/{user}', 'FoodsController@index');

//$router->loadController();
try {
    $router = new core\Router();
//    $router->loadController();
//    throw new wrongControllerException();
//    $contr = new Controller();
} catch (Exception $e) {
//    $e->show();
//    echo $e->getTraceAsString();
}

//if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//    echo 'Post';
//}

//debug($_SERVER);


if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])
    && $_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest") {
    echo 'TRUE';
}
//echo 'TRUE';

$model = new Model();
$model->ret();
?>
<!---->
<!--<form action="/" method="post">-->
<!--    <input type="text" name="text">-->
<!--    <button type="submit">button</button>-->
<!--</form>-->
<!--<script src="public/admin/libs/jquery/dist/jquery.js"></script>-->
<!--<script src="main.js"></script>-->


