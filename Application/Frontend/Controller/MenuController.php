<?php

/**
 * Fichier : /Application/Frontend/Controller/MenuController.php
 * Description : Controleur des menu
 * Auteur : Menu Thomas
 * Date : 10/02/2014
 */

namespace Application\Frontend\Controller;

use Library\AbstractClass\Controller;
use Library\FormBuilder;

class MenuController extends Controller
{
    public function mainAction()
    {
        $this->fetchView();
    }

    public function quickLoginAction()
    {
        // Definition du formulaire d'inscription
        $login_form = array(
            array(
                'name'  => 'username',
                'type'  => 'text',
                'label' => 'Nom d\'utilisateur',
                'rules' => array(
                    'NotNull'   => array('error' => 'Nom d\'utilisateur obligatoire')
                )
            ),
            array(
                'name'  => 'password',
                'type'  => 'password',
                'label' => 'Mot de passe',
                'rules' => array(
                    'NotNull'   => array('error' => 'Mot de passe obligatoire')
                )
            )
        );

        // Instanciation du constructeur de formulaire
        $login_form = new FormBuilder('quick_login', $login_form);

        // Affectation du formulaire à la vue
        $this->app['response']->addVar('quick_login_form', $login_form);

        $this->fetchView();
    }
}