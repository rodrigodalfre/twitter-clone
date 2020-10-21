<?php

namespace MF\Init;

# uma classe abstrata é uma classe que nao pode ser instanciada apenas herdada
abstract class Bootstrap {

    private $routes;

    #uma classe abstract quando herdado por uma classe filha deverá ser implemetado na classe filha
    abstract protected function initRoutes();

    public function __construct(){
		$this->initRoutes();
		$this->run($this->getUrl());
	}

	public function getRoutes(){
		return $this->routes;
	}

	public function setRoutes(array $routes){
		$this->routes = $routes;
	}

    protected function run($url){
		foreach ($this->getRoutes() as $key => $route) {
			if($url == $route['route']){
				$class = "App\\Controllers\\".ucfirst($route['controller']);
				
				//Instancia de uma classe cujo o nome e o namespace foi formado dinamicamente.
				$controller = new $class;

				$action = $route['action'];

				$controller->$action();

			};
		}
    }
    
    protected function getUrl() {
        # parse_url: ela recebe uma url, interpreta e retorna os componentes(array)
        # $_SERVER $_SERVER is an array containing information such as headers, paths, and script locations.
        # PHP_URL_PATH retorno apenas a string relativa a URL
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

}

?>