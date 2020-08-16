<?php


namespace controllers;


use core\Controller;
use core\Request;
use function debug;

/**
 * Class MainController
 * @package controllers
 */
class MainController extends Controller
{

    /**
     * @param Request|null $request
     */
    public function index(Request $request = null)
    {
//        if ($request != null) {
//            $req = $request->get(['id', 'name', 'age']);
////            debug($req);
//        }

//        debug($request->get());
//        echo $_POST['text'];
        $this->view->render('main.index');
    }

    public function about()
    {
        $this->view->render('main.about');
    }

    public function contacts()
    {
        $this->view->render('main.contacts');
    }

    public function foods()
    {
        $this->view->render('main.foods');
    }

    public function food()
    {
        $this->view->render('main.food');
    }

}