<?php

/**
 * Fichier : /Controller/ClientController.php
 * Description : Controleur des clients
 * Auteur : Thomas Menu
 * Date : 10/02/2014
 */

namespace Controller;

use Library\AbstractController;

class ClientController extends AbstractController
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
        $this->app['response']->addVar('_MAIN_TITLE', 'Clients');
        
        $client_manager = $this->app['manager']->getManagerOf('Client');

        $clients_list = $client_manager->selectAll();
        $this->app['response']->addVar('clients_list', $clients_list);

        $this->fetch();
    }
}