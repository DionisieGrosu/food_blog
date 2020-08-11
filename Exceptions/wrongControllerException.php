<?php


namespace exceptions;


use Exception;

class wrongControllerException extends Exception
{

    function show()
    {
        echo 'Message: ' . parent::getMessage() . '</br>';
        echo 'File: ' . parent::getFile();
    }
}