<?php

/**
 * Fichier : /Application/Frontend/Controller/UserController.php
 * Description : Controleur des utilisateurs
 * Auteur : Thomas Menu
 * Date : 10/02/2014
 */

namespace Application\Frontend\Controller;

use Library\AbstractClass\Controller;
use Library\Utils;
use Model\Entity\Client;
use Library\FormBuilder;

class UserController extends Controller
{
    public function loginAction()
    {
        $this->app['response']->addVar('_MAIN_TITLE', 'Connexion');

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
        $login_form = new FormBuilder('login', $login_form);

        if ($this->app['request']->method() == 'POST')
        {
            // Si l'utilisateur provient du formulaire de connexion rapide
            if (isset($_POST['quick_login_form_token'])) {
                $_SESSION['login_form_token'] = $_SESSION['quick_login_form_token'];
                $_POST['login_form_token']    = $_POST['quick_login_form_token'];
            }

            // Chargement des données
            $login_form->handleForm($_POST);

            // Validation du formulaire
            switch ($login_form->isValid())
            {
                case FormBuilder::FORM_VALID:

                    // Récupération du compte client à partir du username
                    $client = $this->app['manager']->getManagerOf('Client')->getByUsername( $login_form->getField('username')->getValue() );
                    
                    if ($client)
                    {
                        $hashed_password = Utils::hashString( $login_form->getField('password')->getValue(), $client->getSalt() );

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
                            // Définition d'un message
                            $this->app['session']->setFlashMessage('danger', 'Le nom d\'utilisateur ou le mot de passe est incorrect.');
                        }
                    }
                    else
                    {
                        // Définition d'un message
                        $this->app['session']->setFlashMessage('danger', 'Le nom d\'utilisateur ou le mot de passe est incorrect.');
                    }

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
        $this->app['response']->addVar('login_form', $login_form);

        $this->fetch();
    }

    public function logoutAction()
    {
        // Deconnexion
        $this->app['session']->setAuth(false);
        $this->app['session']->setAttr('id',       0);
        $this->app['session']->setAttr('username', '');
        $this->app['session']->setAttr('email',    '');
        $this->app['session']->setAttr('roles',    array('NOT_CONNECTED'));

        // Définition d'un message et redirection
        $this->app['session']->setFlashMessage('success', 'Vous êtes maintenant déconnecté.');
        $this->app['response']->redirect('frontend.home.index');
    }

    public function signupAction()
    {
        $this->app['response']->addVar('_MAIN_TITLE', 'Inscription');

        // Definition du formulaire d'inscription
        $signup_form = array(

            // Identifiants
            array(
                'name'  => 'username',
                'type'  => 'text',
                'label' => 'Nom d\'utilisateur',

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
                            'manager'     => $this->app['manager']->getManagerOf('Client'),
                            'test_method' => 'getByUsername',
                        )
                    )
                )
            ),
            array(
                'name'  => 'password',
                'type'  => 'password',
                'label' => 'Mot de passe',

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
            array(
                'name'  => 'confirm_password',
                'type'  => 'password',
                'label' => 'Répétez mot de passe',

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

                'rules' => array(
                    'NotNull' => array('error' => 'Adresse email obligatoire'),
                    'Email'   => array('error' => 'Adresse email invalide')
                )
            ),

            // Coordonnée
            array(
                'name'  => 'lastname',
                'type'  => 'text',
                'label' => 'Nom',

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
                'label' => ''
            ),
            array(
                'name'  => 'city',
                'type'  => 'text',
                'label' => 'Ville',

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

        // Instanciation du constructeur de formulaire
        $client_form = new FormBuilder('signup', $signup_form);

        if ($this->app['request']->method() == 'POST')
        {
            $client_form->handleForm($_POST);

            // Validation du formulaire
            switch ($client_form->isValid())
            {
                case FormBuilder::FORM_VALID:

                    // Affectation des donnés
                    $client = new Client();

                    $client->setUsername($_POST['username']);
                    $client->setEmail($_POST['email']);
                    $client->setRoles('USER');

                    $client->setLastname($_POST['lastname']);
                    $client->setFirstname($_POST['firstname']);
                    $client->setAddress($_POST['address0'] . '|' . $_POST['address1']);
                    $client->setPostal_code($_POST['postal_code']);
                    $client->setCity($_POST['city']);
                    $client->setCountry($_POST['country']);

                    $client->setPassword( Utils::hashString($_POST['password'], $client->getSalt()) );

                    // Enregsitrement
                    $this->app['manager']->getManagerOf('Client')->save($client);
                    
                    // Définition d'un message et redirection
                    $this->app['session']->setFlashMessage('success', 'Vous êtes bien inscrit, vous pouvez maintenant vous connecter.');
                    $this->app['response']->redirect('frontend.user.login');

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
        $this->app['response']->addVar('signup_form', $client_form);

        $this->fetch();
    }
}