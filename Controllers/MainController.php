<?php


namespace controllers;


use core\Request;
use function debug;

class MainController extends Controller
{

    public function index(Request $request = null)
    {
        if ($request != null) {
            $req = $request->get(['id', 'name']);
            debug($req);
        }

    }
}