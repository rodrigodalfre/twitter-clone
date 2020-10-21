<?php

//Especificação psr-4, espera que o script 
//contido dentro de um diretório esteja em um namespace compatível com aquele diretório
namespace App;

use MF\Init\Bootstrap;

class Route extends Bootstrap{
	
	protected function initRoutes() {
		
		$routes['home'] = array(
			'route' => '/',
			'controller' => 'indexController',
			'action' => 'index'
		);

		$this->setRoutes($routes);
	}

}


?>