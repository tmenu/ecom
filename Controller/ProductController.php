<?php

/**
 * Fichier : /Controller/ProductController.php
 * Description : Controleur des produits
 * Auteur : Thomas Menu
 * Date : 10/02/2014
 */

namespace Controller;

use Library\Utils;
use Library\AbstractController;
use Model\Entity\Product;

class ProductController extends AbstractController
{
    public function init()
    {
        // Si l'utilisateur est connecté
        /*if ($this->app['session']->isAuth() !== true) 
        {
            $this->app['response']->redirect('frontend.member.login');
        }*/
    }

    /**
     * Action : index
     * Params : void
     * Author : Thomas Menu
     */
    public function indexAction()
    {
        // Définition du titre
        $this->app['response']->addVar('_MAIN_TITLE', 'Produits');

        // Recupération de la liste des produits
        $product_manager = $this->app['manager']->getManagerOf('Product');

        $product_list = $product_manager->selectAll();

        $this->app['response']->addVar('products_list', $product_list);

        // Génération de la vue
        $this->fetch();
    }

    /**
     * Action : add
     * Params : void
     * Author : Thomas Menu
     */
    public function addAction()
    {
        // Définition du titre
        $this->app['response']->addVar('_MAIN_TITLE', 'Nouveau produit');

        // Si le formulaire à été soumit
        if ($this->app['request']->method() == 'POST')
        {
            // Validation des données
            $form_errors = array();

            // Nom obligatoire
            //     non utilisé
            if (empty($_POST['name'])) {
                $form_errors['name'] = 'Nom obligatoire';
            }
            else {
                $prod_manager = $this->app['manager']->getManagerOf('Product');

                // Si le nom du produit est déjà utilisé
                if ($prod_manager->selectByName($_POST['name'])) {
                    $form_errors['name'] = 'Nom déjà utilisé';
                }
            }

            // Prix obligatoire
            if (empty($_POST['price'])) {
                $form_errors['price'] = 'Prix obligatoire';
            }

            // Image obligatoire
            //
            //

            // Si aucune erreur : création du produit
            if (empty($form_errors))
            {
                // Création d'un produit
                $product = new Product();

                $product->setName($_POST['name']);
                $product->setPrice($_POST['price']);

                // Enregistrement du produit
                $prod_manager = $this->app['manager']->getManagerOf('Product');

                $prod_manager->insert($product);

                // Définition d'un message et redirection
                $this->app['session']->setFlashMessage('success', 'Le produit à bien été enregistré.');
                $this->app['response']->redirect('product.index');
            }
            else // Si ajout des erreurs à la vue
            {  
                $this->app['response']->addVar('form_errors', $form_errors);
            }
        }

        // Ajout du fichier JS pour gérer l'upload
        $this->app['response']->addJsEnd('fileupload.js');

        // Génération de la vue
        $this->fetch();
    }

    /**
     * Action : edit
     * Params : string $name
     *          int    $id
     * Author : Thomas Menu
     */
    public function editAction()
    {
        // Définition du titre
        $this->app['response']->addVar('_MAIN_TITLE', 'Edition d\'un produit');

        // Récupération du produit à modifier
        $prod_manager = $this->app['manager']->getManagerOf('Product');

        $product = $prod_manager->select($_GET['id']);

        // Si le produit n'éxiste pas : erreur
        if ($product === false)
        {
            $this->app['session']->setFlashMessage('danger', 'Le produit à éditer n\'éxiste pas !');
            $this->app['response']->redirect('product.index');
        }

        // Si le formulaire à été soumit
        if ($this->app['request']->method() == 'POST')
        {
            // Validation des données
            $form_errors = array();

            // Nom obligatoire
            //     non utilisé
            if (empty($_POST['name'])) {
                $form_errors['name'] = 'Nom obligatoire';
            }
            else {
                $prod_manager = $this->app['manager']->getManagerOf('Product');

                // Si le nom du produit est diffèrent de l'ancien et déjà utilisé
                if ($_POST['name'] != $product['name'] && $prod_manager->selectByName($_POST['name'])) {
                    $form_errors['name'] = 'Nom déjà utilisé';
                }
            }

            // Prix obligatoire
            if (empty($_POST['price'])) {
                $form_errors['price'] = 'Prix obligatoire';
            }

            // Image obligatoire
            //
            //

            // Si aucune erreur : création du produit
            if (empty($form_errors))
            {
                // Edition du produit
                $product->setName($_POST['name']);
                $product->setPrice($_POST['price']);

                // Enregistrement du produit
                $prod_manager = $this->app['manager']->getManagerOf('Product');

                $prod_manager->update($product);

                // Définition d'un message et redirection
                $this->app['session']->setFlashMessage('success', 'Le produit à bien été édité.');
                $this->app['response']->redirect('product.index');
            }
            else // Sinon ajout des erreurs à la vue
            {  
                $this->app['response']->addVar('form_errors', $form_errors);
            }
        }
        else // Valeurs par defaut
        {
            $_POST['name']  = $product->getName();
            $_POST['price'] = $product->getPrice();
        }

        // Ajout du fichier JS pour gérer l'upload
        $this->app['response']->addJsEnd('fileupload.js');

        // Génération de la vue
        $this->fetch();
    }

    /**
     * Action : delete
     * Params : string $name
     *          int    $id
     * Author : Thomas Menu
     */
    public function deleteAction()
    {
        // Définition du titre
        $this->app['response']->addVar('_MAIN_TITLE', 'Supression d\'un produit');

        // Récupération du produit à supprimer
        $prod_manager = $this->app['manager']->getManagerOf('Product');

        $product = $prod_manager->select($_GET['id']);

        // Si le produit n'éxiste pas : erreur
        if ($product === false)
        {
            $this->app['session']->setFlashMessage('danger', 'Le produit à supprimer n\'éxiste pas !');
            $this->app['response']->redirect('product.index');
        }

        // Si le formulaire à été soumit
        if ($this->app['request']->method() == 'POST')
        {
            // Supression du produit
            $prod_manager = $this->app['manager']->getManagerOf('Product');

            $prod_manager->delete($product->getId());

            // Définition d'un message et redirection
            $this->app['session']->setFlashMessage('success', 'Le produit à bien été supprimé.');
            $this->app['response']->redirect('product.index');
        }
        else // Donnée
        {
            $this->app['response']->addVar('product_name', $product->getName());
        }

        // Génération de la vue
        $this->fetch();
    }
}