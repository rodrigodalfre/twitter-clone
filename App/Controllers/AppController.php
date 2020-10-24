<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class AppController extends Action {

    public function timeline() {

        $this->validaSessao();

        //recuperar tweets
        $tweet = Container::getModel('Tweet');

        $tweet->__set('id_usuario', $_SESSION['id']);


        $this->view->tweets = $tweet->getAll();

        $this->render('timeline');
        
    }

    public function tweet() {

        $this->validaSessao();

        $tweet = Container::getModel('Tweet');

        $tweet->__set('tweet', $_POST['tweet']);
        $tweet->__set('id_usuario', $_SESSION['id']);

        $tweet->salvar();

        header('Location: /timeline');

    
    }

    //Método para validar sessão.
    public function validaSessao() {
        session_start();
        //se ñ estiver setado
        if(!isset($_SESSION['id']) || $_SESSION['id'] == '' ||
        !isset($_SESSION['nome']) || $_SESSION['nome'] == '' ){
            header('Location: /?login=erro');
        }
    }

}


?>