<?php


namespace core;


use function count;
use function debug;
use function extract;

/**
 * Class Request
 * @package core
 */
class Request
{

    private $paramsArray;


    public function __construct(Array $params = [], Array $values = [])
    {
        if (count($params) != 0) {
            if (count($values) != 0) {
                foreach ($params as $key => $param) {
                    $this->paramsArray[$param] = $values[$key];
                }

            } else {
                foreach ($params as $param) {
                    if (isset($_GET[$param])) {
//                        echo 'hello';
                        $this->paramsArray[$param] = $_GET[$param];
                        debug($this->paramsArray);
                    }

                }

            }


        }


    }

    /**
     * @param array $arr
     */
    public function get(Array $arr = [])
    {
        $array = [];
        if (count($this->paramsArray) > 0) {
            if (count($arr) > 0) {
                echo 'hello';
                foreach ($arr as $key) {
                    $array[$key] = $this->paramsArray[$key];
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