<?php

/**
 * Fichier : /Library/autoload.php
 * Description : Fonction d'autochargement des classes
 * Auteur Thomas Menu
 * Date : 07/12/2013
 */

function chargerClasse($class_name)
{
	$filename = dirname(__DIR__) . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class_name) . '.php';

	// Si le fichier existe
	if (file_exists($filename)) {
		require_once $filename;
	}
	else {
		throw new Exception('File '. $filename . ' doesn\'t exists !');
	}
}

spl_autoload_register('chargerClasse');