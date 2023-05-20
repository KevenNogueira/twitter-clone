<?php

namespace App\Controllers;


use MF\Controller\Action;
use MF\Model\Container;

class IndexController extends Action

{
    public function index()
    {
        $this->render('Index');
    }

    public function inscreverse()
    {
        $this->view->erroCadastro = false;
        $this->view->usuarioExistente = false;
        $this->render('Inscreverse');
    }

    public function registrar()
    {
        $usuario = Container::getModel('Usuario');

        $usuario->__set('nome', $_POST['usuario']);
        $usuario->__set('email', $_POST['email']);
        $usuario->__set('senha', $_POST['senha']);

        if ($usuario->validarCadastro()) {

            if (count($usuario->getUsuaruioPorEmail()) == 0) {

                $usuario->insereUsuario();
                $this->render('Cadastro');
            } else {

                $this->view->usuarioExistente = true;
                $this->view->erroCadastro = false;

                $this->render('Inscreverse');
            }
        } else {


            $this->view->erroCadastro = true;
            $this->view->usuarioExistente = false;

            $this->render('Inscreverse');
        }
    }
}