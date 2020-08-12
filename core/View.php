<?php


namespace core;


use function array_pop;
use function count;
use function debug;
use function explode;
use function file_exists;
use function implode;
use function is_dir;
use function ob_get_clean;
use function ob_get_contents;
use function ob_start;
use function preg_match;
use function preg_split;
use function scandir;
use function str_pad;
use function str_replace;
use function str_split;
use function strpos;
use function trim;

/**
 * Class View
 * @package core
 */
class View
{
    /**
     * @var array
     */
    private $dirArray = ['public', 'views'];

    /**
     * @var array
     */
    private $textArray = ['html', 'php'];


    /**
     * @param String $str
     * @param array $params
     */
    public function render(String $str, Array $params = [])
    {
        $str = trim($str, '/');

        if (preg_match('/[A-Za-z0-9][\.\/][A-Za-z0-9]/', $str)) {

            if (preg_match('/[A-Za-z0-9][\.\/][A-Za-z0-9]*:[A-Za-z0-9]/', $str)) {

                $viewPath = str_replace('.', '/', $str);
                preg_match_all('/[A-Za-z0-9]*\//', $viewPath, $matches);
                $dirName = trim(implode("", $matches[0]), '/');

                $flag = false;
                foreach (scandir('Views/' . $dirName) as $layout) {
                    if ($layout == 'layouts') {
                        if (is_dir('Views/' . $dirName . '/' . $layout)) {

                            if (count(scandir('Views/' . $dirName . '/' . $layout)) == 2) {
//                                echo 'hello';
                                ob_start();
                                require 'Views/' . substr($viewPath, 0, strpos($viewPath, ':')) . '.html';
                                $content = ob_get_clean();
                                require 'Views/' . $dirName . '/' . trim(substr($viewPath, strpos($viewPath, ':')), ':')
                                    . '.html';
                                $flag = true;

                            } else {
//                                echo preg_match('/:[A-Za-z0-9]*/', $viewPath);
//                                echo substr($viewPath, strpos($viewPath, ':')) . '</br>';
//                                echo substr($viewPath, 0, strpos($viewPath, ':'));
                                ob_start();
                                require 'Views/' . substr($viewPath, 0, strpos($viewPath, ':')) . '.html';
                                $content = ob_get_clean();
                                require 'Views/' . $dirName . '/' . $layout . '/' . trim(substr($viewPath, strpos($viewPath,
                                        ':')), ':') . '.html';
                                $flag = true;

                            }
                        }
                    }
                }

                if (!$flag) {
                    echo 'View was not found!';
                }

            } else {

                $viewPath = str_replace('.', '/', $str);
                preg_match_all('/[A-Za-z0-9]*\//', $viewPath, $matches);
                $dirName = trim(implode("", $matches[0]), '/');

                $flag = false;
                foreach (scandir('Views/' . $dirName) as $layout) {
                    if ($layout == 'layouts') {

                        if (is_dir('Views/' . $dirName . '/' . $layout)) {

                            if (count(scandir('Views/' . $dirName . '/' . $layout)) == 2) {

                                require 'Views/' . $viewPath . '.html';
                                $flag = true;
                                break;

                            } else {

                                $fileName = scandir('Views/' . $dirName . '/' . $layout);

                                ob_start();
                                require 'Views/' . $viewPath . '.html';
                                $content = ob_get_clean();

                                require 'Views/' . $dirName . '/' . $layout . '/' . array_pop($fileName);
                                $flag = true;
                                break;
                            }
                        }
                    }
                }
                if (!$flag) {
                    require 'Views/' . $viewPath . '.html';
                }
//                debug(scandir('Views/' . $dirName . '/layouts'));

            }
        } else {
            if (preg_match('/[A-Za-z0-9]:[A-Za-z0-9]/', $str)) {

                $fileNameArray = explode(':', trim($str, '/'));
                $flag = false;
                foreach (scandir('Views') as $layout) {

                    if ($layout == 'layouts') {

                        if (is_dir('Views/' . $layout)) {

                            if (count(scandir('Views/' . $layout)) == 2) {

                                ob_start();
                                require 'Views/' . $fileNameArray[0] . '.html';
                                $content = ob_get_clean();

                                require 'Views/' . $fileNameArray[1] . '.html';
                                $flag = true;
                                break;

                            } else {

                                $dirName = scandir('Views/' . $layout);

                                ob_start();
                                require 'Views/' . $fileNameArray[0] . '.html';
                                $content = ob_get_clean();

                                require 'Views/' . $layout . '/' . array_pop($dirName);
                                $flag = true;
                                break;
                            }
                        }
                    }
                }

                if (!$flag) {
                    echo 'View was not found!';
                }
            } else {
                $flag = false;
                foreach (scandir('Views') as $layout) {
                    if ($layout == 'layouts') {
                        if (is_dir('Views/' . $layout)) {
                            if (count(scandir('Views/' . $layout)) == 2) {

                                require 'Views/' . $str . '.html';
                                $flag = true;
                                break;

                            } else {

                                $fileName = scandir('Views/' . $layout);

                                ob_start();
                                require 'Views/' . $str . '.html';
                                $content = ob_get_clean();

                                require 'Views/' . $layout . '/' . array_pop($fileName);
                                $flag = true;
                                break;
                            }
                        }
                    }
                }
                if (!$flag) {
                    require 'Views/' . $str . '.html';
                }
            }

        }
//        if (preg_match('/[A-Za-z0-9][\.\/][A-Za-z0-9]/', $str)) {
//            $viewPath = str_replace('.', '/', $str);
//            $fileExist = false;
//            foreach ($this->dirArray as $dir) {
//                foreach ($this->extArray as $ext) {
//                    if (file_exists($dir . '/' . $viewPath . '.' . $ext)) {
//                        require $dir . '/' . $viewPath . '.' . $ext;
//                        $fileExist = true;
//                        break;
//                    }
//                }
//            }
//            if (!$fileExist) {
//                echo 'File was not found!';
//            }
//        } else {
//            $fileExist = false;
//            foreach ($this->dirArray as $dir) {
//                foreach ($this->extArray as $ext) {
//                    if (file_exists($dir . '/' . $str . '.' . $ext)) {
//                        require $dir . '/' . $str . '.' . $ext;
//                        $fileExist = true;
//                        break;
//                    }
//                }
//            }
//            if (!$fileExist) {
//                echo 'File was not found!';
//            }
//        }
    }

}