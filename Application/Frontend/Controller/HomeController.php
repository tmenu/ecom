<?php

/**
 * Fichier : /Application/Frontend/Controller/HomeController.php
 * Description : Controleur d'accueil
 * Auteur : Thomas Menu
 * Date : 10/02/2014
 */

namespace Application\Frontend\Controller;

use Library\AbstractClass\Controller;

class HomeController extends Controller
{
	public function indexAction()
	{
		$this->app['response']->addVar('_MAIN_TITLE', 'Accueil');

        $products_list = $this->app['manager']->getManagerOf('Product')->getAll();

        $this->app['response']->addVar('products_list', $products_list);

		$this->fetch();
	}
}