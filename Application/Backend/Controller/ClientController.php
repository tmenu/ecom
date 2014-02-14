<?php

/**
 * Fichier : /Application/Backend/Controller/ClientController.php
 * Description : Controleur des clients
 * Auteur : Florian Martinelli
 * Date : 10/02/2014
 */

namespace Application\Backend\Controller;

use Library\AbstractClass\Controller;
use Library\Utils;
use Library\FormBuilder;
use Model\Entity\Client;

class ClientController extends Controller
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
        $this->app['response']->addVar('_MAIN_TITLE', 'Clients');
        
        $client_manager = $this->app['manager']->getManagerOf('Client');

        $clients_list = $client_manager->getAll();
        $this->app['response']->addVar('clients_list', $clients_list);

        $this->fetch();
    }

        /**
     * Action : edit
     * Author : Thomas Menu
     */
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
            // Définition du titre
            $this->app['response']->addVar('_MAIN_TITLE', 'Edition d\'un client');

            // Récupération du client à modifier
            $client = $this->app['manager']->getManagerOf('Client')->get($_GET['client_id']);

            // Si le client n'éxiste pas : erreur
            if ($client === false)
            {
                $this->app['session']->setFlashMessage('danger', 'Le client à éditer n\'éxiste pas !');
                $this->app['response']->redirect('backend.client.index');
            }
        }

        // Definition du formulaire pour un client
        $client_form = array(

            // Identifiants
            array(
                'name'  => 'username',
                'type'  => 'text',
                'label' => 'Nom d\'utilisateur',
                'value' => $client->getUsername(),

                'rules' => array(
                    'NotNull'   => array('error' => 'Nom d\'utilisateur obligatoire'),
                    'MinLenght' => array(
                        'error' => 'Minimum 3 caractères',
                        'data'  => array(
                            'min_lenght' => 3
                        )
                    ),
                    'MaxLenght' => array(
                        'error' => 'Maximum 255 caractères',
                        'data'  => array(
                            'max_lenght' => 255
                        )
                    ),
                    'NotExistsInDb' => array(
                        'error' => 'Nom d\'utilisateur non disponible',
                        'data'  => array(
                            'manager'       => $this->app['manager']->getManagerOf('Client'),
                            'test_method'   => 'getByUsername',
                            'current_value' => $client->getUsername(),
                        )
                    )
                )
            ),
            'password' => array(
                'name'  => 'password',
                'type'  => 'password',
                'label' => 'Mot de passe',
                'help_text' => ($client->isNew()) ? '' : 'Laissez vide pour conserver l\'ancien',

                'rules' => array(
                    'NotNull'   => array('error' => 'Mot de passe obligatoire'),
                    'MinLenght' => array(
                        'error' => 'Minimum 3 caractères',
                        'data'  => array(
                            'min_lenght' => 3
                        )
                    ),
                    'MaxLenght' => array(
                        'error' => 'Maximum 255 caractères',
                        'data'  => array(
                            'max_lenght' => 255
                        )
                    )
                )
            ),
            'confirm_password' => array(
                'name'  => 'confirm_password',
                'type'  => 'password',
                'label' => 'Confimer',

                'rules' => array(
                    'NotNull'   => array('error' => 'Confirmation mot de passe obligatoire'),
                    'MinLenght' => array(
                        'error' => 'Minimum 3 caractères',
                        'data'  => array(
                            'min_lenght' => 3
                        )
                    ),
                    'MaxLenght' => array(
                        'error' => 'Maximum 255 caractères',
                        'data'  => array(
                            'max_lenght' => 255
                        )
                    )
                )
            ),
            array(
                'name'  => 'email',
                'type'  => 'email',
                'label' => 'Adresse email',
                'value' => $client->getEmail(),

                'rules' => array(
                    'NotNull' => array('error' => 'Adresse email obligatoire'),
                    'Email'   => array('error' => 'Adresse email invalide')
                )
            ),
            array(
                'name'     => 'roles',
                'type'     => 'select',
                'label'    => 'Rôle(s)',
                'value'    => $client->getRoles(),
                'help_text' => 'Maintenez la touche CTRL pour une séléction multiple',
                
                'choices'  => $this->app['config']['roles'],
                'multiple' => true,
                'size'     => 3,

                'rules' => array(
                    'NotNull' => array('error' => 'Séléctionnez au moins un rôle')
                )
            ),

            // Coordonnée
            array(
                'name'  => 'lastname',
                'type'  => 'text',
                'label' => 'Nom',
                'value' => $client->getLastname(),

                'rules' => array(
                    'NotNull' => array('error' => 'Nom obligatoire'),
                    'MinLenght' => array(
                        'error' => 'Minimum 3 caractères',
                        'data'  => array(
                            'min_lenght' => 3
                        )
                    ),
                    'MaxLenght' => array(
                        'error' => 'Maximum 255 caractères',
                        'data'  => array(
                            'max_lenght' => 255
                        )
                    )
                )
            ),
            array(
                'name'  => 'firstname',
                'type'  => 'text',
                'label' => 'Prénom',
                'value' => $client->getFirstname(),

                'rules' => array(
                    'NotNull' => array('error' => 'Prénom obligatoire'),
                    'MinLenght' => array(
                        'error' => 'Minimum 3 caractères',
                        'data'  => array(
                            'min_lenght' => 3
                        )
                    ),
                    'MaxLenght' => array(
                        'error' => 'Maximum 255 caractères',
                        'data'  => array(
                            'max_lenght' => 255
                        )
                    )
                )
            ),
            array(
                'name'  => 'address0',
                'type'  => 'text',
                'label' => 'Adresse',
                'value' => substr($client->getAddress(), 0, strpos($client->getAddress(), '|')),

                'rules' => array(
                    'NotNull' => array('error' => 'Address obligatoire'),
                    'MinLenght' => array(
                        'error' => 'Minimum 3 caractères',
                        'data'  => array(
                            'min_lenght' => 3
                        )
                    )
                )
            ),
            array(
                'name'  => 'address1',
                'type'  => 'text',
                'label' => '',
                'value' => substr($client->getAddress(), strpos($client->getAddress(), '|')+1),
            ),
            array(
                'name'  => 'city',
                'type'  => 'text',
                'label' => 'Ville',
                'value' => $client->getCity(),

                'rules' => array(
                    'NotNull' => array('error' => 'Ville obligatoire'),
                    'MinLenght' => array(
                        'error' => 'Minimum 3 caractères',
                        'data'  => array(
                            'min_lenght' => 3
                        )
                    ),
                    'MaxLenght' => array(
                        'error' => 'Maximum 255 caractères',
                        'data'  => array(
                            'max_lenght' => 255
                        )
                    )
                )
            ),
            array(
                'name'  => 'postal_code',
                'type'  => 'text',
                'label' => 'Code postal',
                'value' => $client->getPostal_code(),

                'rules' => array(
                    'NotNull' => array('error' => 'Code postal obligatoire'),
                    'MinLenght' => array(
                        'error' => 'Minimum 2 caractères',
                        'data'  => array(
                            'min_lenght' => 2
                        )
                    ),
                    'MaxLenght' => array(
                        'error' => 'Maximum 255 caractères',
                        'data'  => array(
                            'max_lenght' => 255
                        )
                    )
                )
            ),
            array(
                'name'  => 'country',
                'type'  => 'text',
                'label' => 'Pays',
                'value' => $client->getCountry(),

                'rules' => array(
                    'NotNull' => array('error' => 'Pays obligatoire'),
                    'MinLenght' => array(
                        'error' => 'Minimum 3 caractères',
                        'data'  => array(
                            'min_lenght' => 3
                        )
                    ),
                    'MaxLenght' => array(
                        'error' => 'Maximum 255 caractères',
                        'data'  => array(
                            'max_lenght' => 255
                        )
                    )
                )
            )
        );

        // Si c'est une édition : champs password optionnel
        if (!$client->isNew()) {
            unset($client_form['password']['rules']['NotNull']);
            unset($client_form['confirm_password']['rules']['NotNull']);
        }

        // Instanciation du constructeur de formulaire
        $client_form = new FormBuilder('client_form', $client_form);

        if ($this->app['request']->method() == 'POST')
        {
            $client_form->handleForm(array_merge($_POST));

            // Validation du formulaire
            switch ($client_form->isValid())
            {
                case FormBuilder::FORM_VALID:

                    // Affectation des données
                    $client->setUsername($_POST['username']);
                    $client->setEmail($_POST['email']);
                    $client->setRoles($_POST['roles']);

                    $client->setLastname($_POST['lastname']);
                    $client->setFirstname($_POST['firstname']);
                    $client->setAddress($_POST['address0'] . '|' . $_POST['address1']);
                    $client->setCity($_POST['city']);
                    $client->setPostal_code($_POST['postal_code']);
                    $client->setCountry($_POST['country']);

                    // Si nouveau client OU nouveau mot de passe
                    if ($client->isNew() || (!$client->isNew() && !empty($_POST['password']))) {
                        $client->setPassword( Utils::hashString($_POST['password']) );
                    }

                    // Enregistrement du client
                    $this->app['manager']->getManagerOf('Client')->save( $client );

                    // Si on créé un produit
                    if ($client->isNew())
                    {
                        $this->app['session']->setFlashMessage('success', 'Le client à bien été créé.');
                    }
                    else // sinon si on edit un produit
                    {
                        $this->app['session']->setFlashMessage('success', 'Le client à bien été édité.');
                    }

                    $this->app['response']->redirect('backend.client.index');

                break;

                case FormBuilder::TOKEN_EXPIRE:

                    $this->app['session']->setFlashMessage('danger', 'La durée de validité du formulaire à éxpirée, veuillez de réessayer.');
                
                break;

                case FormBuilder::TOKEN_INVALID:

                    $this->app['session']->setFlashMessage('danger', 'Le jeton fournit pour le formulaire n\'est pas valide.');
                
                break;
            }
        }

        // Affectation du formulaire à la vue
        $this->app['response']->addVar('client_form', $client_form);

        $this->fetch();
    }

    public function deleteAction()
    {
        $this->app['response']->addVar('_MAIN_TITLE', 'Supression d\'un client');

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