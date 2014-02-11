<?php

/**
 * Fichier : /Controller/ProductController.php
 * Description : Controleur des produits
 * Auteur : Thomas Menu
 * Date : 10/02/2014
 */

namespace Controller;

use Library\Utils;
use Library\AbstractController;
use Model\Entity\Product;

class ProductController extends AbstractController
{
    public function init()
    {
        // Si l'utilisateur est connecté
        /*if ($this->app['session']->isAuth() !== true) 
        {
            $this->app['response']->redirect('frontend.member.login');
        }*/
    }

    public function indexAction()
    {
        $this->app['response']->addVar('_MAIN_TITLE', 'Produits');

        /*$product_m = $this->app['manager']->getManagerOf('Product');

        $p = $product_m->select(1);

        $p->setName('test');

        $product_m->update($p);*/

        $this->fetch();
    }
}