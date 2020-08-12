<?php


namespace core;

use core\Model;
use core\View;

/**
 * Class Controller
 * @package controllers
 */
class Controller
{

    protected $model;
    protected $view;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->model = new Model();
        $this->view = new View();
    }

}