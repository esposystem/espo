<?php
namespace Lib;

class Router {

	
	public static function retrieve_class_name($input) {
		$input = Router::secure_path($input);
		$input = strtolower($input);
		$input = ucfirst($input);
		return $input;
	}
		
	public static function secure_path($path) {
		$path = str_replace('.', '_', $path);
		return $path;
	}
	
	public static function secure_method($method) {
		$method = str_replace('-', '_', $method);
		return $method;
	}
	
	public static function not_found() {
		header("HTTP/1.1 404 Not Found");
		exit;
	}
	
	public static function execute() {
		
		// retrieve route
		
		print_r($_SERVER);
		
		if (isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] != '/' ) {
			$route = $_SERVER['PATH_INFO'];		
		}
		else {
			$route = DEFAULT_ROUTE;
		}
				//echo 	"LA RUTA".$route;
				
		$route = substr($route, 1);
		$route = explode('/', $route);
		
		// retrieve controller
		$controller = $route[0];

		// making the methodology hack proof
		
		$controller = Router::retrieve_class_name($controller);
		
		// check if controller exists
		
		
		 
		$controller_path = CONTROLLER_PATH . lcfirst($controller) . 'Controller.php';		
		
		if (!is_file($controller_path)) {
			Router::not_found();
			return;
		}
		
		require_once $controller_path;
		
		// print_r(get_declared_classes() );
		 
		
		$namespaced_controller = '\\Controller\\' . $controller. 'Controller';
		$o = new $namespaced_controller;

		// retrieve method
		$method = isset($route[1]) ? $route[1] : DEFAULT_ROUTE_METHOD;
		$method = Router::secure_method($method)."Action";

		//echo " check if method exists  $method";
		if (!method_exists($o, $method)) {
			print_r($o);
			echo "metodo no";
			Router::not_found();
			return;
		}else
			echo "metodo si $method";
		
		// retrieve arguments
		$args = array_slice($route, 2);

		// check if arguments satisfy method requirements
		$reflector = new \ReflectionClass($namespaced_controller);
		$reflector_method = $reflector->getMethod($method);
		if (count($args) < $reflector_method->getNumberOfRequiredParameters()) {
			Router::not_found();
			return;
		}
		
		// call controller method with arguments
		call_user_func_array(array($o, $method), $args);		
	}
}