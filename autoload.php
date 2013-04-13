<?php
spl_autoload_register(function($className){
	$path = __DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR 
		  . str_replace(
				'\\', DIRECTORY_SEPARATOR, $className
			) . '.php';
	if(is_file($path)) {
		require_once $path;
	}
});

