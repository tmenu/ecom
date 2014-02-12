<?php

/**
 * Fichier : /Application/Backend/Controller/AdminController.php
 * Description : Controleur d'administration
 * Auteur : Florian Martinelli
 * Date : 10/02/2014
 */

namespace Application\Backend\Controller;

use Library\AbstractController;

class AdminController extends AbstractController
{
    public function init()
    {
        if (!$this->app['session']->hasRole('ADMIN'))
        {
            $this->app['session']->setFlashMessage('danger', 'Vous n\'avez pas le droit d\'accéder à cette page.');
            $this->app['response']->redirect('frontend.home.index');
        }
    }
    
    public function indexAction()
    {
        $this->app['response']->addVar('_MAIN_TITLE', 'Administration');

        $this->fetch();
    }
}