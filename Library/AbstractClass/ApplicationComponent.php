<?php

/**
 * Fichier : /Library/AbstractClass/ApplicationComponent.php
 * Description : Modèle d'un composant d'application
 * Auteur Thomas Menu
 * Date : 08/12/2013
 */

namespace Library\AbstractClass;

use Library\Application;

abstract class ApplicationComponent
{
    protected $app = null; 

    public function __construct(Application $app)
    {
        $this->app = $app;
    }
}