<?php


namespace exceptions;


use Exception;

/**
 * Class wrongControllerException
 * @package exceptions
 */
class wrongControllerException extends Exception
{

    function show()
    {
        echo 'Message: ' . parent::getMessage() . '</br>';
        echo 'File: ' . parent::getFile();
    }
}