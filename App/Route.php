<?php

namespace App;

use MF\Init\Bootstrap;

class Route extends Bootstrap
{
    protected function initRoutes()
    {
        $routes['home'] = array(
            'route' => '/',
            'controller' => 'IndexController',
            'action' => 'index'
        );

        $routes['inscreverse'] = array(
            'route' => '/inscreverse',
            'controller' => 'IndexController',
            'action' => 'inscreverse'
        );

        $routes['registrar'] = array(
            'route' => '/registrar',
            'controller' => 'IndexController',
            'action' => 'registrar'
        );

        $routes['autenticar'] = array(
            'route' => '/autenticar',
            'controller' => 'AuthController',
            'action' => 'autenticar'
        );

        $routes['timeline'] = array(
            'route' => '/timeline',
            'controller' => 'AppController',
            'action' => 'timeline'
        );

        $routes['sair'] = array(
            'route' => '/sair',
            'controller' => 'AuthController',
            'action' => 'sair'
        );

        $routes['tweet'] = array(
            'route' => '/tweet',
            'controller' => 'AppController',
            'action' => 'tweet'
        );

        $routes['quem_seguir'] = array(
            'route' => '/quem_seguir',
            'controller' => 'AppController',
            'action' => 'quemSeguir'
        );

        $routes['acao'] = array(
            'route' => '/acao',
            'controller' => 'AppController',
            'action' => 'acao'
        );

        $routes['remove_tweet'] = array(
            'route' => '/remove_tweet',
            'controller' => 'AppController',
            'action' => 'removeTweet'
        );

        $routes['perfil'] = array(
            'route' => '/perfil',
            'controller' => 'AppController',
            'action' => 'perfil'
        );

        $routes['biografia'] = array(
            'route' => '/biografia',
            'controller' => 'AppController',
            'action' => 'biografia'
        );

        $routes['redes_sociais'] = array(
            'route' => '/redes_sociais',
            'controller' => 'AppController',
            'action' => 'redesSociais'
        );

        $routes['seguindo'] = array(
            'route' => '/seguindo',
            'controller' => 'AppController',
            'action' => 'seguindo'
        );

        $this->setRoute($routes);
    }
}
