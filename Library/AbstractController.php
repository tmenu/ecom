<?php

/**
 * Fichier : /Library/AbstractController.php
 * Description : Modèle d'un controleur
 * Auteur Thomas Menu
 * Date : 07/12/2013
 */

namespace Library;

use Exception;

class AbstractController
{
	protected $app = null; // Lien vers l'application

    protected $application;
    protected $controller;
    protected $action;

	/**
     * Initialise le controleur
     * @param obj Application $app L'application ayant instancié le controleur
     * @param string $application Le nom de l'application
     * @param string $controller Le nom du controleur
     * @param string $action Le nom de l'action
     * @return void
     */
	public function __construct(Application $app, $application, $controller, $action)
	{
		$this->app = $app;

        $this->application = $application;
        $this->controller  = $controller;
        $this->action      = $action;

		// Création et définition du chemin du layout
		$layout = dirname(__DIR__) . '/Application/' . $this->application . '/View/layout.php';

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
		$method_name = $this->action . 'Action';

		// Si la méthode n'éxiste pas
		if (!method_exists($this, $method_name)) {
			throw new Exception('Method '. $method_name . ' doesn\'t exists !');
		}

		// Initialisation
		$this->init();

		// Execution
		$this->$method_name();
	}

	/**
     * Genération de la page
     * @param string $view = '' La vue à générée
     * @return void
     */
	public function fetch($view = '')
	{
		// Si aucune vue spécifique n'est requise : vue par defaut
		if ($view === '') {
			// Création du chemin de la vue
			$view = dirname(__DIR__) . '/Application/' . $this->application . '/View/' . $this->controller . '/' . $this->action . '.php';
		}
        else {
            $view = dirname(__DIR__) . '/Application/' . $this->application . '/View/' . $view;
        }

		// Génération du la page finale
		$this->app['response']->render($view);
	}

    /**
     * Genération d'une vue
     * @param string $view = '' La vue à générée
     * @return void
     */
    public function fetchView($view = '')
    {
        // Si aucune vue spécifique n'est requise : vue par defaut
        if ($view === '') {
            // Création du chemin de la vue
            $view = dirname(__DIR__) . '/Application/' . $this->application . '/View/' . $this->controller . '/' . $this->action . '.php';
        }
        else {
            $view = dirname(__DIR__) . '/Application/' . $this->application . '/View/' . $view . '';
        }

        // Génération du la page finale
        $this->app['response']->renderView($view);
    }
}