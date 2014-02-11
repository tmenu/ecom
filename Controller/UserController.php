<?php

/**
 * Fichier : /Controller/UserController.php
 * Description : Controleur des utilisateurs
 * Auteur : Thomas Menu
 * Date : 10/02/2014
 */

namespace Controller;

use Library\AbstractController;

class UserController extends AbstractController
{
    public function init()
    {
        // Si l'utilisateur est connecté
        /*if ($this->app['session']->isAuth() !== true) 
        {
            $this->app['response']->redirect('frontend.member.login');
        }*/
    }

    public function loginAction()
    {
        $this->app['response']->addVar('_MAIN_TITLE', 'Connexion');

        $this->fetch();
    }

    public function logoutAction()
    {
        $this->app['response']->addVar('_MAIN_TITLE', 'Deconnexion');

        $this->fetch();
    }

    public function signupAction()
    {
        $this->app['response']->addVar('_MAIN_TITLE', 'Inscription');

        // Si le formulaire à été soumit
        if ($this->app['request']->method() == 'POST')
        {
            // Validation des données
            $form_errors = array();

            // Username obligatoire
            //          non utilisé
            if (empty($_POST['username'])) {
                $form_errors['username'] = 'Nom d\'utilisateur obligatoire';
            }
            else {
                $prod_manager = $this->app['manager']->getManagerOf('Client');

                // Si le nom du produit est déjà utilisé
                /*if ($prod_manager->selectByUsername($_POST['username'])) {
                    $form_errors['username'] = 'Nom d\'utilisateur déjà utilisé';
                }*/
            }

            // Password obligatoire
            if (empty($_POST['password'])) {
                $form_errors['password'] = 'Mot de passe obligatoire';
            }

            // Confirmation password identique au premier
            if ($_POST['password'] != $_POST['confirm_password']) {
                $form_errors['confirm_password'] = 'Doit être identique au premier';
            }

            // Email obligatoire
            if (empty($_POST['email'])) {
                $form_errors['email'] = 'Email obligatoire';
            }

            // Si aucune erreur : création du produit
            if (empty($form_errors))
            {
                // Création d'un produit
                /*$product = new Product();

                $product->setName($_POST['name']);
                $product->setPrice($_POST['price']);

                // Enregistrement du produit
                $prod_manager = $this->app['manager']->getManagerOf('Product');

                $prod_manager->insert($product);*/

                // Définition d'un message et redirection
                $this->app['session']->setFlashMessage('success', 'Le produit à bien été enregistré.');
                $this->app['response']->redirect('product.index');
            }
            else // Si ajout des erreurs à la vue
            {  
                $this->app['response']->addVar('form_errors', $form_errors);
            }
        }

        $this->fetch();
    }
}