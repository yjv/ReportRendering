<?php
use Symfony\Component\ClassLoader\UniversalClassLoader;
var_dump(file_exists(__DIR__ . '/../vendor/autoload.php'), __DIR__ . '/../vendor/autoload.php');
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
	
	require_once __DIR__ . '/../vendor/autoload.php';
}else{

	require_once $_SERVER['SYMFONY'].'/Symfony/Component/ClassLoader/UniversalClassLoader.php';
	
	
	$loader = new UniversalClassLoader();
	$loader->registerNamespace('Symfony', $_SERVER['SYMFONY']);
	$loader->registerPrefix('Twig_', $_SERVER['TWIG']);
	$loader->register();
	
	spl_autoload_register(function($class)
	{
		if (0 === strpos($class, 'Yjv\\Bundle\\ReportRenderingBundle\\')) {
			$path = implode('/', array_slice(explode('\\', $class), 3)).'.php';
			require_once __DIR__.'/../'.$path;
			return true;
		}
	});
}