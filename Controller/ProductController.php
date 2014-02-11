<?php

/**
 * Fichier : /Controller/ProductController.php
 * Description : Controleur des produits
 * Auteur : Thomas Menu
 * Date : 10/02/2014
 */

namespace Controller;

use Library\AbstractController;

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

    public function indexAction()
    {
        $this->app['response']->addVar('_MAIN_TITLE', 'Produits');
        
        // Récupération de l'instance de PDO
        //$pdo = $this->app['manager']->getPDO();

        // Création de la requète
        //$q = $pdo->query("SELECT id_news, subject, content, DATE_FORMAT(date, '%e %M %Y à %H:%i') as dateformated FROM news ORDER BY date DESC");
        //$results = $q->fetchAll();
        
        // Ajout de la liste à la vue
        //$this->app['response']->addVar('news_list', $results);

        $this->fetch();
    }
}