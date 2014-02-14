<?php

/**
 * Fichier : /Library/Router.php
 * Description : Routage des URL vers les Applications, controlleurs et actions correspondants
 * Auteur Thomas Menu
 * Date : 08/12/2013
 */

namespace Library\ApplicationComponent;

use Library\AbstractClass\ApplicationComponent;

class Router extends ApplicationComponent
{
	protected $routes = array(); // Tableau des routes

	/**
	 * Constructeur du router
	 * @param void
	 * @return void
	 */
	public function __construct()
	{
		// Récupération des routes
		$this->routes = json_decode(file_get_contents(realpath(__DIR__ . '/../../config/routes.json')), true);
	}

	/**
	 * Recherche d'une route à partir d'une URL
	 * @param string L'URL à rechercher
	 * @return obj Route : route correspondante 
	 */
	public function matchRoute($uri)
	{
		// Parcours des diffèrentes routes
		foreach ($this->routes as $key => $route)
		{
			// Si c'est une commentaire : on ignore
			if ($key == '_comment') {
				continue;
			}

			// Création du mask de la regex
			$regex = '#^' . $this->app['config']['base_url'] . $route['regex'] . '$#';

			// S'il y a des paramètres
			if (isset($route['params']) && !empty($route['params']))
			{
				// Mise en place des mask pour les paramètres
				foreach ($route['params'] as $key => $value) {
					$regex = str_replace($key, $value, $regex);
				}
			}

			// Si la route correspond : on la renvoi avec ses paramètres
			if (preg_match($regex, $uri, $params))
			{
				$route['data'] = array();

				// S'il y a des paramètres
				if (isset($route['params']) && !empty($route['params']))
				{
					$i = 1;
					foreach ($route['params'] as $key => $value) {
						$route['data'][$key] = $params[$i++];
					}
				}

				// Renvois de la route correspondante avec ses paramètres
				return $route;
			}
		}

		// Erreur 404 : aucune route trouvé
		$this->app['response']->redirect404();
	}
}