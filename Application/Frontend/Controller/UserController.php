<?php

/**
 * Fichier : /Application/Frontend/Controller/UserController.php
 * Description : Controleur des utilisateurs
 * Auteur : Thomas Menu
 * Date : 10/02/2014
 */

namespace Application\Frontend\Controller;

use Library\AbstractController;
use Library\Utils;
use Model\Entity\Client;

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

        // Si le formulaire à été soumit : on valide les champs
        if ($this->app['request']->method() == 'POST')
        {
            // Récupération du compte client
            $client = $this->app['manager']->getManagerOf('Client')->getByUsername($_POST['username']);

            if ($client)
            {
                // Hash du password avec le salt du client
                $hashed_password = Utils::hashString($_POST['password'], $client->getSalt());
                
                // Si le client éxiste et que le mot de passe est correcte : les login sont correcte
                if ($hashed_password == $client->getPassword())
                {
                    // Connexion
                    $this->app['session']->setAuth(true);
                    $this->app['session']->setAttr('id',       $client->getId());
                    $this->app['session']->setAttr('username', $client->getUsername());
                    $this->app['session']->setAttr('email',    $client->getEmail());
                    $this->app['session']->setAttr('roles',    $client->getRoles());

                    // Définition d'un message et redirection
                    $this->app['session']->setFlashMessage('success', 'Vous êtes maintenant connecté.');
                    $this->app['response']->redirect('frontend.home.index');
                }
                else
                {
                    // Définition d'un message et redirection
                    $this->app['session']->setFlashMessage('danger', 'Le nom d\'utilisateur ou le mot de passe est incorrect.');
                }
            }
            else
            {
                // Définition d'un message et redirection
                $this->app['session']->setFlashMessage('danger', 'Le nom d\'utilisateur ou le mot de passe est incorrect.');
            }
        }

        $this->fetch();
    }

    public function logoutAction()
    {
        // Deconnexion
        $this->app['session']->setAuth(false);
        $this->app['session']->setAttr('id',       0);
        $this->app['session']->setAttr('username', '');
        $this->app['session']->setAttr('email',    '');
        $this->app['session']->setAttr('roles',    '');

        // Définition d'un message et redirection
        $this->app['session']->setFlashMessage('success', 'Vous êtes maintenant déconnecté.');
        $this->app['response']->redirect('frontend.home.index');
    }

    public function signupAction()
    {
        $this->app['response']->addVar('_MAIN_TITLE', 'Inscription');

        $client = new Client();

        // Si le formulaire à été soumit : on valide les champs
        if ($this->app['request']->method() == 'POST')
        {
            // Liste des erreurs de validations
            $form_errors = array();

            /** Validation des données **/

            // Nom d'utilisateur :
            // - obligatoire
            // - min 2 caractères
            // - max 128 caractères
            // - filtre username

            if (empty($_POST['username'])) {
                $form_errors['username'] = 'Nom de l\'utilisateur obligatoire';
            }
            else if (strlen($_POST['username']) < 2) {
                $form_errors['username'] = 'Minimum 2 caractères';
            }
            else if (strlen($_POST['username']) > 128) {
                $form_errors['username'] = 'Maximum 128 caractères';
            }
            else
            {
                $client_manager = $this->app['manager']->getManagerOf('Client');

                // Test si le nom n'éxiste pas
                if ($client_manager->getByUsername($_POST['username']) > 0) {
                    $form_errors['username'] = 'Nom d\'utilisateur déjà utilisée';
                }
            }

            // Mot de passe :
            // - obligatoire
            // - min 6 caractères
            // - max 255 caractères

            if (empty($_POST['password'])) {
                $form_errors['password'] = 'Mot de passe obligatoire';
            }
            else if (strlen($_POST['password']) < 6) {
                $form_errors['password'] = 'Minimum 6 caractères';
            }
            else if (strlen($_POST['password']) > 255) {
                $form_errors['password'] = 'Maximum 255 caractères';
            }

            // Confirmation mot de passe :
            // - obligatoire
            // - identique au mot de passe précédent

            if (empty($_POST['repassword'])) {
                $form_errors['repassword'] = 'Confirmation mot de passe obligatoire';
            }
            else if ($_POST['repassword'] !== $_POST['password']) {
                $form_errors['repassword'] = 'Doit être identique au premier';
            }

            // Email :
            // - obligatoire
            // - filtre email

            if (empty($_POST['email'])) {
                $form_errors['email'] = 'Adresse email obligatoire';
            }
            else if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
                $form_errors['email'] = 'Adresse email invalide';
            }
            else if ($client['email'] != $_POST['email'] && $client_manager->getByEmail($_POST['email']) > 0)
            {
                $client_manager = $this->app['manager']->getManagerOf('Client');

                // Test si le nom n'éxiste pas
                if ($client_manager->getByEmail($_POST['email']) > 0) {
                    $form_errors['email'] = 'Adresse email déjà utilisée';
                }
            }

            // Nom :
            // - obligatoire

            if (empty($_POST['lastname'])) {
                $form_errors['lastname'] = 'Nom obligatoire';
            }

            // Prenom :
            // - obligatoire

            if (empty($_POST['firstname'])) {
                $form_errors['firstname'] = 'Prénom obligatoire';
            }

            // Adresse :
            // - obligatoire

            if (empty($_POST['address'][0])) {
                $form_errors['address'] = 'Adresse obligatoire';
            }

            // Ville :
            // - obligatoire

            if (empty($_POST['city'])) {
                $form_errors['city'] = 'Ville obligatoire';
            }

            // Code postal :
            // - obligatoire

            if (empty($_POST['postal_code'])) {
                $form_errors['postal_code'] = 'Code postal';
            }

            // Pays :
            // - obligatoire

            if (empty($_POST['country'])) {
                $form_errors['country'] = 'Pays obligatoire';
            }

            // S'il n'y a aucune erreur : enregistrement en BDD
            if (empty($form_errors))
            {
                $client->setUsername($_POST['username']);
                $client->setEmail($_POST['email']);
                $client->setRoles('USER');

                $client->setLastname($_POST['lastname']);
                $client->setFirstname($_POST['firstname']);
                $client->setAddress($_POST['address'][0] . '|' . $_POST['address'][1]);
                $client->setPostal_code($_POST['postal_code']);
                $client->setCity($_POST['city']);
                $client->setCountry($_POST['country']);

                $client->setPassword( Utils::hashString($_POST['password'], $client->getSalt()) );

                $client_manager->save($client);

                // Définition d'un message et redirection
                $this->app['session']->setFlashMessage('success', 'Vous êtes bien inscrit, vous pouvez maintenant vous connecter.');
                $this->app['response']->redirect('frontend.user.login');
            }

            // Affectation des erreurs de validation à la vue
            $this->app['response']->addVar('form_errors', $form_errors);
        }

        $this->fetch();
    }
}