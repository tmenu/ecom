<?php

/**
 * Fichier : /Application/Frontend/Controller/CartController.php
 * Description : Controleur du panier
 * Auteur : Menu Thomas
 * Date : 10/02/2014
 */

namespace Application\Frontend\Controller;

use Library\AbstractClass\Controller;

class CartController extends Controller
{
    public function init()
    {
        
    }

    public function showAction()
    {
        $cart_list = array();

        $this->app['response']->addVar('cart_list', $cart_list);

        $this->fetchView();
    }

    public function indexAction()
    {
        $this->app['response']->addVar('test', $_GET['test']);

        $this->fetchView();
    }
}