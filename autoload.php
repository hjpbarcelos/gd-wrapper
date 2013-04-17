<?php
define('ROOT', __DIR__);
{
    $loader = function($className, $pathName){
        $className = ltrim($className, '\\');
        $fileName  = '';
        $namespace = '';

        if ($lastNsPos = strrpos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }

        $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
        $fileName = $pathName . DIRECTORY_SEPARATOR . $fileName;
        if (is_file($fileName)) {
            require $fileName;
        }
    };
    spl_autoload_register(function($className) use ($loader) {
        $loader($className, __DIR__ . '/src');
        $loader($className, __DIR__ . '/test');
    });
}