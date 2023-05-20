<?php

namespace App\Controllers;

use MF\Controller\Action;


class IndexController extends Action

{
    public function index()
    {
        $this->render('Index');
    }
    public function inscreverse()
    {
        $this->render('inscreverse');
    }
}