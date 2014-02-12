<?php

/**
 * Fichier : /Application/Backend/Controller/ClientController.php
 * Description : Controleur des clients
 * Auteur : Florian Martinelli
 * Date : 10/02/2014
 */

namespace Application\Backend\Controller;

use Library\AbstractController;
use Library\Utils;
use Model\Entity\Client;

class ClientController extends AbstractController
{
    public function init()
    {
        
    }

    public function indexAction()
    {
        $this->app['response']->addVar('_MAIN_TITLE', 'Clients');
        
        $client_manager = $this->app['manager']->getManagerOf('Client');

        $clients_list = $client_manager->getAll();
        $this->app['response']->addVar('clients_list', $clients_list);

        $this->fetch();
    }

    public function editAction()
    {
        // Si on à pas d'identifiant : création
        if (!isset($_GET['client_id']))
        {
            // Définition du titre
            $this->app['response']->addVar('_MAIN_TITLE', 'Création d\'un client');

            $client = new Client();
        }
        else // Sinon : edition
        {
            $this->app['response']->addVar('_MAIN_TITLE', 'Edition d\'un client');

            $client_manager = $this->app['manager']->getManagerOf('Client');
            $client = $client_manager->get($_GET['client_id']);

            if ($client === false)
            {
                $this->app['session']->setFlashMessage('danger', 'Le client à éditer n\'éxiste pas !');
                $this->app['response']->redirect('backend.client.index');
            }
        }

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

                // Si on créé un produit
                if ($client->isNew())
                {
                    // Test si le nom n'éxiste pas
                    if ($client_manager->getByUsername($_POST['username'])) {
                        $form_errors['username'] = 'Nom d\'utilisateur déjà utilisée';
                    }
                }
                else // sinon si on edit un produit
                {
                    // Test si le nom n'éxiste pas uniquement si ce n'est pas le même
                    if ($_POST['username'] != $client['username'] && $client_manager->getByUsername($_POST['username'])) {
                        $form_errors['username'] = 'Nom d\'utilisateur déjà utilisée';
                    }
                }
            }

            // Mot de passe :
            // - obligatoire
            // - min 6 caractères
            // - max 255 caractères

            if ($client->isNew() || (!$client->isNew() && !empty($_POST['password'])))
            {
                if (empty($_POST['password'])) {
                    $form_errors['password'] = 'Mot de passe obligatoire';
                }
                else if (strlen($_POST['password']) < 6) {
                    $form_errors['password'] = 'Minimum 6 caractères';
                }
                else if (strlen($_POST['password']) > 255) {
                    $form_errors['password'] = 'Maximum 255 caractères';
                }
            }

            // Confirmation mot de passe :
            // - obligatoire
            // - identique au mot de passe précédent

            if ($client->isNew() && empty($_POST['repassword'])) {
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
            else
            {
                $client_manager = $this->app['manager']->getManagerOf('Client');

                // Si on créé un produit
                if ($client->isNew())
                {
                    // Test si le nom n'éxiste pas
                    if ($client_manager->getByEmail($_POST['email'])) {
                        $form_errors['email'] = 'Adresse email déjà utilisée';
                    }
                }
                else // sinon si on edit un produit
                {
                    // Test si le nom n'éxiste pas uniquement si ce n'est pas le même
                    if ($_POST['email'] != $client['email'] && $client_manager->getByEmail($_POST['email'])) {
                        $form_errors['email'] = 'Adresse email déjà utilisée';
                    }
                }
            }

            // Roles :
            // - obligatoire
            // - existants

            if (empty($_POST['roles'])) {
                $form_errors['roles'] = 'Sélectionnez au moins un rôle';
            }
            else {
                foreach ($_POST['roles'] as $role)
                {
                    if (!array_key_exists($role, $this->app['config']['roles'])) {
                        $form_errors['roles'] = 'Rôle invalide';
                    }
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
                $client->setRoles($_POST['roles']);

                $client->setLastname($_POST['lastname']);
                $client->setFirstname($_POST['firstname']);
                $client->setAddress($_POST['address'][0] . '|' . $_POST['address'][1]);
                $client->setPostal_code($_POST['postal_code']);
                $client->setCity($_POST['city']);
                $client->setCountry($_POST['country']);

                if (!$client->isNew()) {
                    $client->setPassword( Utils::hashString($_POST['password']) );
                }

                $client_manager->save($client);

                // Définition d'un message et redirection
            
                // Si on créé un produit
                if ($client->isNew())
                {
                    $this->app['session']->setFlashMessage('success', 'Le client a bien été créé.');
                }
                else // sinon si on edit un produit
                {
                    $this->app['session']->setFlashMessage('success', 'Le client a bien été edité.');
                }

                $this->app['response']->redirect('backend.client.index');
            }

            // Affectation des erreurs de validation à la vue
            $this->app['response']->addVar('form_errors', $form_errors);
        }
        else
        {
            $_POST['username'] = $client->getUsername();
            $_POST['email']    = $client->getEmail();
            $_POST['roles']    = $client->getRoles();

            $_POST['lastname']  = $client->getLastname();
            $_POST['firstname'] = $client->getFirstname();

            $address = explode('|', $client->getAddress());
            $_POST['address'][0] = $address[0];
            $_POST['address'][1] = @$address[1];

            $_POST['postal_code'] = $client->getPostal_code();
            $_POST['city']        = $client->getCity();
            $_POST['country']     = $client->getCountry();
        }

        // Si on créé un produit
        if ($client->isNew())
        {
            $this->fetch('Client/add.php');
        }
        else // sinon si on edit un produit
        {
            $this->fetch('Client/edit.php');
        }
    }

    public function deleteAction()
    {
        $this->app['response']->addVar('_MAIN_TITLE', 'Supression d\'un produit');

        $client_manager = $this->app['manager']->getManagerOf('Client');

        $client = $client_manager->get($_GET['id']);

        if ($client === false)
        {
            $this->app['session']->setFlashMessage('danger', 'Le client à supprimer n\'éxiste pas !');
            $this->app['response']->redirect('client.index');
        }

        // Si le formulaire à été soumit
        if ($this->app['request']->method() == 'POST')
        {
            $client_manager->delete($client->getId());

            // Définition d'un message et redirection
            $this->app['session']->setFlashMessage('success', 'Le client à bien été supprimé.');
            $this->app['response']->redirect('backend.client.index');
        }
        else // Donnée
        {
            $this->app['response']->addVar('client_name', $client->getUsername());
        }

        // Génération de la vue
        $this->fetch();
    }
}