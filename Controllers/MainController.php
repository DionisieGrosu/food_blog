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
        if ($request != null) {
            $req = $request->get(['id', 'name', 'age']);
//            debug($req);
        }


    }
}