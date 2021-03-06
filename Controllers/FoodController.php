<?php


namespace controllers;


use core\Controller;
use core\Request;
use function debug;
use function dir;
use function opendir;
use function readdir;
use function scandir;

/**
 * Class FoodController
 * @package controllers
 */
class FoodController extends Controller
{

    /**
     * Index method of FoodController controllers.
     * @param Request $request
     */
    public function index(Request $request = null)
    {
        if ($request != null) {
            $arr = $request->get(['page']);
        }

//        debug($request->get());
        $this->view->render('admin.index');
//        echo readdir('views/admin/lauouts');
//        opendir('views/admin/lauouts/index.php');
//        debug(readdir(opendir('views/admin/layouts')));
//        debug(scandir('views/admin/'));
//        opendir('views/admin/layouts');
    }

    public function foods(Request $request = null)
    {
        $this->view->render('admin.foods');
    }

    public function login(Request $request = null)
    {
        $this->view->render('admin.login');
    }

    public function users(Request $request = null)
    {
        $this->view->render('admin.users');
    }
}