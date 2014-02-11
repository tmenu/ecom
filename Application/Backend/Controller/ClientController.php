<?php

/**
 * Fichier : /Application/Backend/Controller/ClientController.php
 * Description : Controleur des clients
 * Auteur : Thomas Menu
 * Date : 10/02/2014
 */

namespace Application\Backend\Controller;

use Library\AbstractController;
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

        $clients_list = $client_manager->selectAll();
        $this->app['response']->addVar('clients_list', $clients_list);

        $this->fetch();
    }

    public function addAction()
    {
        $this->app['response']->addVar('_MAIN_TITLE', 'Ajouter');

        $client_manager = $this->app['manager']->getManagerOf('Client');

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
                $form_errors['username'] = 'Nom de l\'utilisateur';
            }
            else if (strlen($_POST['username']) < 2) {
                $form_errors['username'] = 'Minimum 2 caractères';
            }
            else if (strlen($_POST['username']) > 128) {
                $form_errors['username'] = 'Maximum 128 caractères';
            }
            else if ($client_manager->selectByUsername($_POST['username']) > 0)
            {
                $form_errors['username'] = 'Nom d\'utilisateur déjà utilisée';
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
            else if ($client_manager->selectByEmail($_POST['email']) > 0)
            {
                $form_errors['email'] = 'Adresse email déjà utilisée';
            }

            // S'il n'y a aucune erreur : enregistrement en BDD
            if (empty($form_errors))
            {
                $client = new Client();

                $client->setUsername($_POST['username']);
                $client->setPassword($_POST['password']);
                $client->setEmail($_POST['email']);

                $client_manager->insert($client);

                // Définition d'un message et redirection
                $this->app['session']->setFlashMessage('success', 'Le nouveau client a bien été ajouté.');
                $this->app['response']->redirect('client.index');
            }

            // Affectation des erreurs de validation à la vue
            $this->app['response']->addVar('form_errors', $form_errors);
      
        }

         $this->fetch();
    }

    public function editAction()
    {
        $this->app['response']->addVar('_MAIN_TITLE', 'Edit');

        // Vérification des paramètres
        if (!isset($_GET['id']))
        {
            $this->app['session']->setFlashMessage('danger', '<b>Erreur :</b> Identifiant de client à modifier introuvable.');
            $this->app['response']->redirect('client.index');
        }

        $client_manager = $this->app['manager']->getManagerOf('Client');
        $client = $client_manager->select($_GET['id']);

        if ($client === false)
        {
            $this->app['session']->setFlashMessage('danger', 'Identifiant de client à modifier introuvable.');
            $this->app['response']->redirect('client.index');
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
                $form_errors['username'] = 'Nom de l\'utilisateur';
            }
            else if (strlen($_POST['username']) < 2) {
                $form_errors['username'] = 'Minimum 2 caractères';
            }
            else if (strlen($_POST['username']) > 128) {
                $form_errors['username'] = 'Maximum 128 caractères';
            }
            else if ($client['username'] != $_POST['username'] && $client_manager->selectByUsername($_POST['username']) > 0)
            {
                $form_errors['username'] = 'Nom d\'utilisateur déjà utilisée';
            }

            // Mot de passe :
            // - obligatoire
            // - min 6 caractères
            // - max 255 caractères

            /*if (empty($_POST['password'])) {
                $form_errors['password'] = 'Mot de passe obligatoire';
            }
            else if (strlen($_POST['password']) < 6) {
                $form_errors['password'] = 'Minimum 6 caractères';
            }
            else if (strlen($_POST['password']) > 255) {
                $form_errors['password'] = 'Maximum 255 caractères';
            }*/

            // Confirmation mot de passe :
            // - obligatoire
            // - identique au mot de passe précédent

            /*if (empty($_POST['repassword'])) {
                $form_errors['repassword'] = 'Confirmation mot de passe obligatoire';
            }
            else if ($_POST['repassword'] !== $_POST['password']) {
                $form_errors['repassword'] = 'Doit être identique au premier';
            }*/

            // Email :
            // - obligatoire
            // - filtre email

            if (empty($_POST['email'])) {
                $form_errors['email'] = 'Adresse email obligatoire';
            }
            else if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
                $form_errors['email'] = 'Adresse email invalide';
            }
            else if ($client['email'] != $_POST['email'] && $client_manager->selectByEmail($_POST['email']) > 0)
            {
                $form_errors['email'] = 'Adresse email déjà utilisée';
            }

            // S'il n'y a aucune erreur : enregistrement en BDD
            if (empty($form_errors))
            {
                $client->setUsername($_POST['username']);
                //$client->setPassword($_POST['password']);
                $client->setEmail($_POST['email']);

                $client_manager->update($client);

                // Définition d'un message et redirection
                $this->app['session']->setFlashMessage('success', 'Le client a bien été modifié.');
                $this->app['response']->redirect('client.index');
            }

            // Affectation des erreurs de validation à la vue
            $this->app['response']->addVar('form_errors', $form_errors);
        }
        else
        {
            $_POST['username'] = $client->getUsername();
            $_POST['email'] = $client->getEmail();
        }

        $this->fetch();
    }

    public function deleteAction()
    {

        $this->app['response']->addVar('_MAIN_TITLE', 'Supression d\'un produit');

        $client_manager = $this->app['manager']->getManagerOf('Client');

        $client = $client_manager->select($_GET['id']);

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
            $this->app['response']->redirect('client.index');
        }
        else // Donnée
        {
            $this->app['response']->addVar('client_name', $client->getUsername());
        }

        // Génération de la vue
        $this->fetch();
    }
}