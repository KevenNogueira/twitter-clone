<?php

namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class AppController extends Action
{
    public function timeline()
    {
        session_start();

        if (!empty($_SESSION['id']) && !empty($_SESSION['nome'])) {

            $this->render('timeline');
        } else {
            header('Location: /?login=erro');
        }
    }

    public function tweet()
    {
        session_start();
        if (!empty($_SESSION['id']) && !empty($_SESSION['nome'])) {

            $tweer = Container::getModel('Tweet');
            $tweer->__set('tweet', $_POST['tweet']);
            $tweer->__set('id_usuario', $_SESSION['id']);
            $tweer->salvar();

            echo '<pre>';
            print_r($tweer);
            echo '</pre>';
        } else {
            header('Location: /?login=erro');
        }
    }
}
