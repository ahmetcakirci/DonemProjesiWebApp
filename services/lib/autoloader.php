<?php
/*
*@Package GPSTAKİPSİSTEMİ
*@Author Ahmet ÇAKIRCI <ahmetcakirci@gmail.com>
*@Version 1.0
*@Description
*@Copyright
*@Date October 2015
*/

define("DS", DIRECTORY_SEPARATOR);
define("PATH", $_SERVER['DOCUMENT_ROOT'].DS.'services');

function GPSTakipSistemiAutoload($className){
    $parts = explode('\\', $className);
    $className= end($parts);

    $directoryList=array
    (
        PATH.DS,
        PATH.DS.'lib'.DS,
        PATH.DS.'lib'.DS.'database'.DS,
        PATH.DS.'lib'.DS.'type'.DS,
        PATH.DS.'lib'.DS.'conf'.DS
    );

    $fileNameFormats=array
    (
        '%s.php',
        '%s.class.php',
        'class.%s.php',
        '%s.inc.php',
        'inc.%s.php'
    );

    foreach ($directoryList as $directory)
    {
        foreach ($fileNameFormats as $fileNameFormat)
        {
            if(strpos($className,"_"))
            {
                $temp_path= explode("_", $className);
                $path=$directory.sprintf($fileNameFormat,strtolower($temp_path[0]));
            }
            else
            {
                $path=$directory.sprintf($fileNameFormat,strtolower($className));
            }

            if(file_exists($path))
            {
                if(include_once($path)){}
                else
                {
                    die("{$className} class  yüklenemedi");
                    exit();
                }

                return;
            }
        }
    }
}

if (version_compare(PHP_VERSION, '5.1.2', '>=')) {
    //SPL autoloading was introduced in PHP 5.1.2
    if (version_compare(PHP_VERSION, '5.3.0', '>=')) {
        spl_autoload_register('GPSTakipSistemiAutoload', true, true);
    } else {
        spl_autoload_register('GPSTakipSistemiAutoload');
    }
} else {
    /**
     * Fall back to traditional autoload for old PHP versions
     * @param string $classname The name of the class to load
     */
    function __autoload($classname)
    {
        GPSTakipSistemiAutoload($classname);
    }
}
?>