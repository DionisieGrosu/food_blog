<?php


namespace core;


use function array_key_first;
use function count;
use function debug;
use function extract;
use function gettype;
use function is_integer;

/**
 * Class Request
 * @package core
 */
class Request
{

    private $paramsArray = [];


    public function __construct(Array $params = [])
    {
        if (count($params) != 0) {
            if (is_integer(array_key_first($params))) {
                foreach ($params as $param) {
                    if (isset($_GET[$param])) {
//                        echo 'hello';
                        $this->paramsArray[$param] = $_GET[$param];
                    }

                }
            } else {
                foreach ($params as $key => $param) {
                    $this->paramsArray[$key] = $param;
                }
            }

//            if (count($values) != 0) {
//                foreach ($params as $key => $param) {
//                    $this->paramsArray[$param] = $values[$key];
//                }
//
//            } else {
//                foreach ($params as $param) {
//                    if (isset($_GET[$param])) {
////                        echo 'hello';
//                        $this->paramsArray[$param] = $_GET[$param];
//                        debug($this->paramsArray);
//                    }
//
//                }
//
//            }


        }


    }

    /**
     * @param array $arr
     * @return array
     */
    public function get(Array $arr = [])
    {
        $array = [];
        if (count($this->paramsArray) > 0) {
            if (count($arr) > 0) {
                foreach ($arr as $key) {
                    if (isset($this->paramsArray[$key])) {
                        $array[$key] = $this->paramsArray[$key];
                    }
                }
            } else {
                return $this->paramsArray;

            }
        }
        return $array;
    }

    /**
     * @param array $arr
     */
    public function post(Array $arr)
    {

    }

}