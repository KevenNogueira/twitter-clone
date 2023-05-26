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

        $pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
        $this->view->pagAtiva = $pagina;

        $limit = 5;
        $offSet = ($pagina - 1) * $limit;
        $this->view->tweets = $tweet->getAll($limit, $offSet);

        $totalTweets = $tweet->getTotalRegistros();
        $this->view->totalPag = ceil($totalTweets['total'] / $limit);

        $usuario = Container::getModel('Usuario');
        $usuario->__set('id', $_SESSION['id']);
        $this->view->infoUsuario = $usuario->getInfoUsuario();
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
        $this->view->infoUsuario = $usuario->getInfoUsuario();
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
        if ($acao != 'deixar_de_seguir_perfil') {
            header('Location: /quem_seguir');
        }

        if ($acao == 'deixar_de_seguir_perfil') {

            $usuario->deixarSeguirUsuario($id_usuario_seguindo);
            header('Location: /perfil');
        }
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

        $usuario = Container::getModel('Usuario');
        $usuario->__set('id', $_SESSION['id']);
        $this->view->infoUsuario = $usuario->getInfoUsuario();
        $this->view->totalTweet = $usuario->getTotalTweets();
        $this->view->totalSeguindo = $usuario->getTotalSeguindo();
        $this->view->totalSeguidores = $usuario->getTotalSeguidores();
        $this->view->seguidores = $usuario->getSeguidores();

        $this->render('perfil');
    }

    public function biografia()
    {

        $this->validaAutenticacao();

        $usuario = Container::getModel('Usuario');
        $usuario->__set('id', $_SESSION['id']);
        $usuario->__set('biografia', $_POST['biografia']);

        $usuario->salvarBiografia();

        header('Location: /perfil');
    }

    public function redesSociais()
    {

        $this->validaAutenticacao();

        $usuario = Container::getModel('Usuario');

        $usuario->__set('id', $_SESSION['id']);
        $usuario->__set('facebook', $_POST['facebook']);
        $usuario->__set('instagram', $_POST['instagram']);
        $usuario->__set('linkedin', $_POST['linkedin']);
        $usuario->__set('tiktok', $_POST['tiktok']);
        $usuario->__set('outrosLinks', $_POST['outros']);

        $usuario->salvarRedesSociais();

        header('Location: /perfil');
    }

    public function seguindo()
    {
        $this->validaAutenticacao();

        $pesquisaPor = isset($_GET['pesquisarPor']) ? $_GET['pesquisarPor'] : '';

        if (!empty($pesquisaPor)) {
            $usuario = Container::getModel('Usuario');
            $usuario->__set('id', $_SESSION['id']);
            $usuario->__set('nome', $pesquisaPor);
            $this->view->seguidores = $usuario->pesquisaSeguidores();
            $this->view->infoUsuario = $usuario->getInfoUsuario();
            $this->view->totalTweet = $usuario->getTotalTweets();
            $this->view->totalSeguindo = $usuario->getTotalSeguindo();
            $this->view->totalSeguidores = $usuario->getTotalSeguidores();

            $this->render('perfil');
        } else {
            header('Location: /perfil');
        }
    }
}
