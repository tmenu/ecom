<?php

/**
 * Fichier : /Application/Backend/Controller/ProductController.php
 * Description : Controleur des produits
 * Auteur : Thomas Menu
 * Date : 10/02/2014
 */

namespace Application\Backend\Controller;

use Library\Utils;
use Library\FormBuilder;
use Library\AbstractClass\Controller;
use Model\Entity\Product;

class ProductController extends Controller
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

        // Definition du formulaire pour un produit
        $product_form = array(
            array(
                'name'   => 'name',
                'type'   => 'text',
                'label'  => 'Nom',
                'value'  => $product->getName(),
                
                'rules' => array(
                    'NotNull'   => array('error' => 'Nom du produit obligatoire'),
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
                        'error' => 'Nom de produit déjà existant',
                        'data' => array(
                            'manager'       => $this->app['manager']->getManagerOf('Product'),
                            'test_method'   => 'getByName',
                            'current_value' => $product->getName()
                        )
                    )
                )
            ),
            array(
                'name'   => 'price',
                'type'   => 'number',
                'label'  => 'Prix TTC',
                'value'  => $product->getPrice(),
                
                'rules' => array(
                    'NotNull' => array('error' => 'Prix obligatoire'),
                    'Number'  => array('error' => 'Doit être un nombre valide')
                )
            ),
            array(
                'name'   => 'description',
                'type'   => 'textarea',
                'label'  => 'Description',
                'value'  => $product->getDescription(),
                
                'rules' => array(
                    'NotNull'   => array('error' => 'Description obligatoire'),
                    'MinLenght' => array(
                        'error' => 'Minimum 3 caractères',
                        'data'  => array(
                            'min_lenght' => 3
                        )
                    ),
                )
            ),
            array(
                'name'      => 'image',
                'type'      => 'file',
                'label'     => 'Image',
                'help_text' => ($product->isNew()) ? '' : 'Image actuelle :<img src="' . $product->getImage() . '" alt="Image actuelle" class="product-image thumbnail" />',
                
                'rules' => array(
                    'File' => array(
                        'error' => array(
                            'NO_FILE'           => 'Image obligatoire',
                            'INVALID_EXTENSION' => 'Extensions autorisés : jpeg, jpg, png et gif',
                            'INVALID_SIZE'      => 'Maximum 1mo',
                            'UNKNOW_ERROR'      => 'Erreur pendant le transfert du fichier, veuillez recommencer'
                        ),
                        'data'  => array(
                            'keep_old'   => ($product->isNew()) ? false : true,
                            'extensions' => array('jpg', 'jpeg', 'png', 'gif'),
                            'max_size'   => 1048576, // 1 mo
                        )
                    )
                )
            )
        );

        // Instanciation du constructeur de formulaire
        $product_form = new FormBuilder('product_form', $product_form);

        if ($this->app['request']->method() == 'POST')
        {
            $product_form->handleForm(array_merge($_POST, $_FILES));

            // Validation du formulaire
            switch ($product_form->isValid())
            {
                case FormBuilder::FORM_VALID:

                    // Si nouveau produit OU ancien produit avec nouvelle image : upload de l'image
                    if ($product->isNew() || (!$product->isNew() && $product_form->getField('image')->getValue()['error'] != 4))
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

                    // Modification du produit
                    $product->setName($_POST['name']);
                    $product->setPrice($_POST['price']);
                    $product->setDescription($_POST['description']);

                    // Récupération du manager des produits
                    $prod_manager = $this->app['manager']->getManagerOf('Product');

                    // Enregistrement du produit
                    $prod_manager->save($product);

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

                break;

                case FormBuilder::TOKEN_EXPIRE:

                    $this->app['session']->setFlashMessage('danger', 'La durée de validité du formulaire à éxpirée, veuillez de réessayer.');
                
                break;

                case FormBuilder::TOKEN_INVALID:

                    $this->app['session']->setFlashMessage('danger', 'Le jeton fournit pour le formulaire n\'est pas valide.');
                
                break;
            }
        }

        // Ajout du fichier JS pour gérer l'upload
        $this->app['response']->addJsEnd('fileupload.js');

        // Affectation du formulaire à la vue
        $this->app['response']->addVar('product_form', $product_form);

        $this->fetch();
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