<?php

/**
 * Fichier : /Library/AbstractController.php
 * Description : Modèle d'un controleur
 * Auteur Thomas Menu
 * Date : 07/12/2013
 */

namespace Library;

use Exception;
use Library\Page;

class AbstractController
{
	protected $app = null; // Lien vers l'application

	/**
     * Initialise le controleur
     * @param obj Application L'application ayant instancié le controleur
     * @return void
     */
	public function __construct(Application $application)
	{
		$this->app = $application;

		// Création et définition du chemin du layout
		$layout = dirname(__DIR__) . '/Application/' . $this->app['route']['application'] . '/View/layout.php';

		$this->app['response']->setLayout($layout);
	}

	/**
     * Méthode éxécuté avant chaque action
     * Permet d'ajouter des fichier CSS et JS en fonction du controleur courant
     * @param void
     * @return void
     */
	public function init() {}

	/**
     * Execution de l'action demandée
     * @param void
     * @return void
     */
	public function execute()
	{
		// Création du nom de l'action
		$method_name = $this->app['route']['action'] . 'Action';

		// Si la méthode n'éxiste pas
		if (!method_exists($this, $method_name)) {
			throw new Exception('Method '. $method_name . ' doesn\'t exists !');
		}

		// Affectation des paramètres de la route au tableau $_GET pour une utilisation transparente
		foreach ($this->app['route']['data'] as $key => $data) {
			$_GET[substr($key, 1)] = $data;
		}

		// Initialisation
		$this->init();

		// Execution
		$this->$method_name();
	}

	/**
     * Genération de la page
     * @param void
     * @return void
     */
	public function fetch($view = '')
	{
		// Si aucune vue spécifique n'est requise : vue par defaut
		if ($view === '') {
			// Création du chemin de la vue
			$view = dirname(__DIR__) . '/Application/' . $this->app['route']['application'] . '/View/' . $this->app['route']['controller'] . '/' . $this->app['route']['action'] . '.php';
		}
        else {
            $view = dirname(__DIR__) . '/Application/' . $this->app['route']['application'] . '/View/' . $view . '';
        }

		// Génération du la page finale
		$this->app['response']->render($view);
	}
}