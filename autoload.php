<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'helpers.php';

class Autoloader
{
    public static function register()
    {
        spl_autoload_register(function ($class) {
            $file = str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php';
            
            $files_low = explode(DIRECTORY_SEPARATOR, strtolower($file));
            $files = explode(DIRECTORY_SEPARATOR, $file);
            
            array_pop($files_low);

            $file = dirname(__FILE__) . "/" . join(DIRECTORY_SEPARATOR, [ ...$files_low, end($files) ]);

            if (file_exists($file)) {
                require $file;
                return true;
            }
            return false;
        });
    }
}

Autoloader::register();
