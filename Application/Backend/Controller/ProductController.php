<?php

/**
 * Fichier : /Application/Backend/Controller/ProductController.php
 * Description : Controleur des produits
 * Auteur : Thomas Menu
 * Date : 10/02/2014
 */

namespace Application\Backend\Controller;

use Library\Utils;
use Library\AbstractController;
use Model\Entity\Product;

class ProductController extends AbstractController
{
    public function init()
    {
        if (!$this->app['session']->hasRole('ADMIN'))
        {
            $this->app['session']->setFlashMessage('danger', 'Vous n\'avez pas le droit d\'accéder à cette page.');
            $this->app['response']->redirect('frontend.home.index');
        }
    }

    /**
     * Action : index
     * Author : Thomas Menu
     */
    public function indexAction()
    {
        // Définition du titre
        $this->app['response']->addVar('_MAIN_TITLE', 'Produits');

        // Recupération de la liste des produits
        $product_list = $this->app['manager']->getManagerOf('Product')->getAll();

        $this->app['response']->addVar('products_list', $product_list);

        // Génération de la vue
        $this->fetch();
    }

    /**
     * Action : edit
     * Author : Thomas Menu
     */
    public function editAction()
    {
        // Si on à pas d'identifiant : création
        if (!isset($_GET['product_id']))
        {
            // Définition du titre
            $this->app['response']->addVar('_MAIN_TITLE', 'Création d\'un produit');

            $product = new Product();
        }
        else // Sinon : edition
        {
            // Définition du titre
            $this->app['response']->addVar('_MAIN_TITLE', 'Edition d\'un produit');

            // Récupération du produit à modifier
            $product = $this->app['manager']->getManagerOf('Product')->get($_GET['product_id']);

            // Si le produit n'éxiste pas : erreur
            if ($product === false)
            {
                $this->app['session']->setFlashMessage('danger', 'Le produit à éditer n\'éxiste pas !');
                $this->app['response']->redirect('backend.product.index');
            }
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

                // Si on créé un produit
                if ($product->isNew())
                {
                    // Test si le nom n'éxiste pas
                    if ($_POST['name'] != $product['name'] && $prod_manager->getByName($_POST['name'])) {
                        $form_errors['name'] = 'Nom déjà utilisé';
                    }
                }
                else // sinon si on edit un produit
                {
                    // Test si le nom n'éxiste pas uniquement si ce n'est pas le même
                    if ($_POST['name'] != $product['name'] && $prod_manager->getByName($_POST['name'])) {
                        $form_errors['name'] = 'Nom déjà utilisé';
                    }
                }
            }

            // Prix obligatoire
            if (empty($_POST['price'])) {
                $form_errors['price'] = 'Prix obligatoire';
            }

            // Description obligatoire
            if (empty($_POST['description'])) {
                $form_errors['description'] = 'Description obligatoire';
            }

            // Si on créé un produit OU qu'on en edit un et qu'on a selectionné une image
            if ($product->isNew() || (!$product->isNew() && $_FILES['image']['error'] != 4))
            {
                // Image obligatoire
                if ($_FILES['image']['error'] == 4) {
                    $form_errors['image'] = 'Veuillez sélectionnez une image';
                }
                else if ($_FILES['image']['error'] != 0) {
                    $form_errors['image'] = 'Une erreur s\'est produite pendant le transfert du fichier';
                }
                else
                {
                    $extensions_valides = array('jpg' , 'jpeg' , 'gif' , 'png');

                    $extension_upload = strtolower(substr(strrchr($_FILES['image']['name'], '.'), 1));

                    if (!in_array($extension_upload, $extensions_valides)) {
                        $form_errors['image'] = 'Format de fichier non autorisé';
                    }
                }
            }

            // Si aucune erreur : enregistrement du produit
            if (empty($form_errors))
            {
                // Si on créé un produit OU qu'on en edit un et qu'on a selectionné une image
                if ($product->isNew() || (!$product->isNew() && $_FILES['image']['error'] == 0))
                {
                    // Création du chemin de l'image
                    $upload_dir = dirname(__DIR__) . '/../../web';

                    // Si c'est une édition : supression de l'ancienne image
                    if (!$product->isNew())
                    {
                        unlink($upload_dir . $product->getImage());
                    }

                    // Enregistrement de l'image
                    $image_path = '/upload/' . Utils::generateString(30) . '.' . strtolower(substr(strchr($_FILES['image']['name'], '.'), 1));

                    move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir.$image_path);

                    $product->setImage($image_path);
                }

                // Récupération du manager des produits
                $prod_manager = $this->app['manager']->getManagerOf('Product');

                // Modification du produit
                $product->setName($_POST['name']);
                $product->setPrice($_POST['price']);
                $product->setDescription($_POST['description']);

                // Enregistrement du produit
                $prod_manager->save($product);

                // Définition d'un message et redirection

                // Si on créé un produit
                if ($product->isNew())
                {
                    $this->app['session']->setFlashMessage('success', 'Le produit à bien été créé.');
                }
                else // sinon si on edit un produit
                {
                    $this->app['session']->setFlashMessage('success', 'Le produit à bien été édité.');
                }

                $this->app['response']->redirect('backend.product.index');
            }
            else // Sinon ajout des erreurs à la vue
            {  
                $this->app['response']->addVar('form_errors', $form_errors);
            }
        }
        else // Valeurs par defaut
        {
            $_POST['name']        = $product->getName();
            $_POST['price']       = $product->getPrice();
            $_POST['description'] = $product->getDescription();
            $_POST['image']       = $product->getImage();
        }

        // Ajout du fichier JS pour gérer l'upload
        $this->app['response']->addJsEnd('fileupload.js');

        // Génération de la vue

        // Si on créé un produit
        if ($product->isNew())
        {
            $this->fetch('Product/add.php');
        }
        else // sinon si on edit un produit
        {
            $this->fetch('Product/edit.php');
        }
    }

    /**
     * Action : delete
     * Author : Thomas Menu
     */
    public function deleteAction()
    {
        // Définition du titre
        $this->app['response']->addVar('_MAIN_TITLE', 'Supression d\'un produit');

        // Récupération du produit à supprimer
        $prod_manager = $this->app['manager']->getManagerOf('Product');

        $product = $prod_manager->get($_GET['id']);

        // Si le produit n'éxiste pas : erreur
        if ($product === false)
        {
            $this->app['session']->setFlashMessage('danger', 'Le produit à supprimer n\'éxiste pas !');
            $this->app['response']->redirect('backend.product.index');
        }

        // Si le formulaire à été soumit
        if ($this->app['request']->method() == 'POST')
        {
            // Supression du produit
            $prod_manager = $this->app['manager']->getManagerOf('Product');

            $prod_manager->delete($product->getId());

            // Création du chemin de l'image
            $upload_dir = dirname(__DIR__) . '/../../web';
            unlink($upload_dir . $product->getImage());

            // Définition d'un message et redirection
            $this->app['session']->setFlashMessage('success', 'Le produit à bien été supprimé.');
            $this->app['response']->redirect('backend.product.index');
        }
        else // Donnée
        {
            $this->app['response']->addVar('product_name', $product->getName());
        }

        // Génération de la vue
        $this->fetch();
    }
}