<?php

namespace core;

use PDO;
use function debug;

/**
 * Class Model
 * @package models
 */
class Model
{

    public $dbConnection;

    public function __construct()
    {
        $this->dbConnection = new PDO('mysql:host=localhost;dbname=fooddb', "root", "");

    }

    function ret()
    {
        $result = $this->dbConnection->query("Select name,title,description from foods", PDO::FETCH_ASSOC);
//        debug($result->fetchAll());
        foreach ($result->fetchAll() as $row) {
//            echo $row;
        }
//echo $dbConnection->query("Select * from foods");
    }
}
