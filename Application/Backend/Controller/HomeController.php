<?php

/**
 * Fichier : /Application/Backend/Controller/HomeController.php
 * Description : Controleur d'accueil
 * Auteur : Thomas Menu
 * Date : 10/02/2014
 */

namespace Application\Backend\Controller;

use Library\AbstractController;

class HomeController extends AbstractController
{
	public function indexAction()
	{
		$this->app['response']->addVar('_MAIN_TITLE', 'Accueil');

		$this->fetch();
	}
}