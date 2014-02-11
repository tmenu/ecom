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
        
        /*$client_m = $this->app['manager']->getManagerOf('Client');

        $p = $client_m->select(1);

        $p->setUsername('test');

        $client_m->update($p);

        var_dump($p);*/

        $this->fetch();
    }
}