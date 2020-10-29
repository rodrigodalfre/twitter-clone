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

    public function quemSeguir() {
        $this->validaSessao();

        $pesquisarPor = isset($_GET['pesquisarPor']) ? $_GET['pesquisarPor'] : '';

        $usuarios = array();

        if($pesquisarPor != ''){
            
            $usuario = Container::getModel('Usuario');
            $usuario->__set('nome', $pesquisarPor);
            $usuario->__set('id', $_SESSION['id']);
            $usuarios = $usuario->getAll();
        }

        $this->view->usuarios = $usuarios;

        $this->render('quemSeguir');

    }

    public function acao() {
        $this->validaSessao();

        $acao = isset($_GET['acao']) ? $_GET['acao'] : '';
        $id = isset($_GET['id_usuario']) ? $_GET['id_usuario'] : '';
        echo $acao.'<br>'.$id;

        $usuario = Container::getModel('Usuario');
        $usuario->__set('id', $_SESSION['id']);

        if($acao == 'follow'){
            $usuario->follow($id);

        } else if($acao == 'unfollow'){
            $usuario->unfollow($id);

        }

        header('Location: /quem_seguir');

    }

}


?>