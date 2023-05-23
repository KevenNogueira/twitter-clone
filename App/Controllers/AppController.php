<?php

namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class AppController extends Action
{
    public function validaAutenticacao()
    {
        session_start();
        if (!isset($_SESSION['id']) || $_SESSION['id'] == '' || !isset($_SESSION['nome']) || $_SESSION['nome'] == '') {
            header('Location: /?login=erro');
        }
    }

    public function timeline()
    {
        $this->validaAutenticacao();

        $tweet = Container::getModel('Tweet');
        $tweet->__set('id_usuario', $_SESSION['id']);

        $this->view->tweets = $tweet->getAll();

        $usuario = Container::getModel('Usuario');
        $usuario->__set('id', $_SESSION['id']);
        $this->view->nomeUsuario = $usuario->getInfoUsuario();
        $this->view->totalTweet = $usuario->getTotalTweets();
        $this->view->totalSeguindo = $usuario->getTotalSeguindo();
        $this->view->totalSeguidores = $usuario->getTotalSeguidores();

        $this->render('timeline');
    }

    public function tweet()
    {
        $this->validaAutenticacao();

        $tweet = Container::getModel('Tweet');
        $tweet->__set('tweet', $_POST['tweet']);
        $tweet->__set('id_usuario', $_SESSION['id']);
        $tweet->salvar();

        header('Location: /timeline');
    }


    public function quemSeguir()
    {
        $this->validaAutenticacao();

        $pesquisaPor = isset($_GET['pesquisarPor']) ? $_GET['pesquisarPor'] : '';

        $usuarios = array();

        if (!empty($pesquisaPor)) {
            $usuario = Container::getModel('Usuario');
            $usuario->__set('nome', $pesquisaPor);
            $usuario->__set('id', $_SESSION['id']);
            $usuarios = $usuario->getAll();
        }

        $this->view->usuarios = $usuarios;

        $usuario = Container::getModel('Usuario');
        $usuario->__set('id', $_SESSION['id']);
        $this->view->nomeUsuario = $usuario->getInfoUsuario();
        $this->view->totalTweet = $usuario->getTotalTweets();
        $this->view->totalSeguindo = $usuario->getTotalSeguindo();
        $this->view->totalSeguidores = $usuario->getTotalSeguidores();

        $this->render('quemSeguir');
    }

    public function acao()
    {
        $this->validaAutenticacao();

        $acao = isset($_GET['acao']) ? $_GET['acao'] : '';
        $id_usuario_seguindo = isset($_GET['id_usuario']) ? $_GET['id_usuario'] : '';

        $usuario = Container::getModel('Usuario');
        $usuario->__set('id', $_SESSION['id']);

        if ($acao == 'seguir') {

            $usuario->seguirUsuario($id_usuario_seguindo);
        } else if ($acao == 'deixar_de_seguir') {

            $usuario->deixarSeguirUsuario($id_usuario_seguindo);
        }

        header('Location: /quem_seguir');
    }

    public function removeTweet()
    {
        $this->validaAutenticacao();

        $tweet = Container::getModel('Tweet');
        $tweet->__set('id', $_POST['tweet']);
        $tweet->delete();

        header('Location: /timeline');
    }

    public function perfil()
    {
        $this->validaAutenticacao();

        $this->render('perfil');
    }
}
