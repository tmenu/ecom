<?php

/**
 * Fichier : /web/index.php
 * Description : Point d'entrée de l'application
 * Auteur Thomas Menu
 * Date : 07/12/2013
 */

include dirname(__DIR__) . '/Library/autoload.php';

$application = new Library\Application();

$application->run();