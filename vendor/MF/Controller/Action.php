<?php 

namespace MF\Controller;

abstract class Action {

    protected $view;

    public function __construct(){
        //A classe stdClass() é uma classe nativa do PHP.  
        //Atraves dela é possível criar objetos padrões 
        $this->view = new \stdClass();
    }

    protected function render($view, $layout = 'layout'){
        $this->view->page = $view;

        //Verificar se o layout existe para não gerar conflitos
        if(file_exists("../App/Views/".$layout.".phtml")){
            require_once "../App/Views/".$layout.".phtml";
        } else {
            $this->content();
        }        
        
    }

    protected function content() {

        #echo get_class($this);
        $classAtual = get_class($this);
        $classAtual = str_replace('App\\Controllers\\', '', $classAtual);
        $classAtual = strtolower(str_replace('Controller', '', $classAtual));
        
        require_once "../App/Views/".$classAtual."/".$this->view->page.".phtml";        
    }

}


?>