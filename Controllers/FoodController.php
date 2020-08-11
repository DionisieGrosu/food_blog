<?php


namespace controllers;


use core\Request;

class FoodController extends Controller
{

    public function index(Request $request)
    {
        $arr = $request->get(['name']);
        echo $arr['name'];
    }
}