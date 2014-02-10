<?php

/**
 * Fichier : /Application/Backend/Controller/AdminController.php
 * Description : Controleur d'administration
 * Auteur Thomas Menu
 * Date : 07/12/2013
 */

namespace Application\Backend\Controller;

use Library\AbstractController;

class AdminController extends AbstractController
{
	public function init()
	{
		// Si l'utilisateur n'est pas administrateur
		if ($this->app['session']->isAuth() !== true)
		{
			// Définition d'un message et redirection
			$this->app['session']->setFlashMessage('danger', '<b>Erreur :</b> Vous n\'avez pas le droit d\'accéder à cette page.');
			$this->app['response']->redirect('frontend.index.index');
		}

		$this->app['response']->addCss('styles.css');
	}

	public function indexAction()
	{
		$this->app['response']->addVar('_MAIN_TITLE', 'Espace privé');

		$bdd = $this->app['manager']->getPDO();
	}
}