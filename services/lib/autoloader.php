<?php
/*
 *@Package LogoDataTransfer
 *@Author Ahmet ÇAKIRCI <ahmet.cakirci@himnet.com.tr>
 *@Version 1.0
 *@Description
 *@Copyright Himnet İletişim
 *@Date October 2015
 */

define("DS", DIRECTORY_SEPARATOR);
define("PATH", $_SERVER['DOCUMENT_ROOT']);

function LogoTransferAutoload($className){
    $parts = explode('\\', $className);
    $className= end($parts);

    $directoryList=array
    (
        PATH,
        PATH.'lib'.DS,
        PATH.'lib'.DS.'database'.DS,
        PATH.'lib'.DS.'conf'.DS
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
        spl_autoload_register('LogoTransferAutoload', true, true);
    } else {
        spl_autoload_register('LogoTransferAutoload');
    }
} else {
    /**
     * Fall back to traditional autoload for old PHP versions
     * @param string $classname The name of the class to load
     */
    function __autoload($classname)
    {
        LogoTransferAutoload($classname);
    }
}
?>