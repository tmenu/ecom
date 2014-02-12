<?php

/**
 * Fichier : /Application/Frontend/Controller/MenuController.php
 * Description : Controleur des menu
 * Auteur : Menu Thomas
 * Date : 10/02/2014
 */

namespace Application\Frontend\Controller;

use Library\AbstractController;

class MenuController extends AbstractController
{
    public function mainAction()
    {
        $this->fetchView();
    }
}