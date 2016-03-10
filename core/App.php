<?php 
class App 
{
	protected $controller = 'storage';
	protected $method = 'index';
	protected $params = [];
	
	/**
	 * Routing.
	 *
	 * @return array
	 */
	public function __construct()
	{
		$url = $this->parseUrl();
		//Check if given from url controller exist. 
		if( file_exists('core/controllers/' . $url[0] . '.php')){
			$this->controller = $url[0];
			unset($url[0]);
		}
		//Include controller file.
		require_once('core/controllers/' . $this->controller . '.php');
		//Create new object of controller.
		$this->controller = new $this->controller;
		//Check if object has requested method, and if so use it.
		if(isset($url[1]) and method_exists($this->controller, $url[1])) {
			$this->method = $url[1];
			unset($url[1]);
		}
		//Check if ther is params, if so - set the params to class property.
		$this->params = $url ? array_values($url) : [];
		//Triger action.
		call_user_func_array([$this->controller, $this->method], $this->params);
	}
	
	/**
	 * Parse url to array.
	 *
	 * @return array
	 */
	public function parseUrl()
	{
		$path = str_replace(BASE_URL, '',  $_SERVER['REQUEST_URI']);
		if(isset($path)) {
			return $url = explode('/', filter_var(trim($path, '/'), FILTER_SANITIZE_URL));
		}
	}
}