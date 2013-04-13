<?php
spl_autoload_register(function($className){
	$ds = DIRECTORY_SEPARATOR;	
	$path = stream_resolve_include_path(
		'src' . $ds . str_replace('\\', $ds, $className) . '.php'
	);
	
	if($path !== false) {
		require_once $path;
	}
});

