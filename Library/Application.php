<?php

/**
 * Fichier : /Library/Application.php
 * Description : Classe principale
 * Auteur Thomas Menu
 * Date : 07/12/2013
 */

namespace Library;

use Library\ApplicationComponent\Router;
use Library\ApplicationComponent\Request;
use Library\ApplicationComponent\Response;
use Library\ApplicationComponent\Session;
use Library\ApplicationComponent\Manager;

class Application implements \ArrayAccess
{
	protected $config   = array(); // Tableau des données de config

	protected $request  = null;    // Objet de gestion de la requète HTTP
	protected $response = null;    // Objet de gestion de la réponse HTTP
	protected $manager  = null;    // Objet de gestion de la base de donnée
	protected $session  = null;    // Objet de gestion de la session

	/**
	 * Constructeur de l'application
	 * @param void
	 * @return void
	 */
	public function __construct()
	{
		// Chargement des données de config
		$this->config = json_decode(file_get_contents(dirname(__DIR__) . '/config/config.json'), true);

		// Initialisation des composants de l'application
		$this->request  = new Request($this);
		$this->response = new Response($this);
		$this->session  = new Session($this);
		$this->manager  = new Manager($this);
	}

	/**
	 * Méthode d'instanciation et d'éxécution du contrôleur correspondant à la route demandée
	 * @param void
	 * @return void
	 */
	public function run()
	{
		// Recherche de la route demandée
		$router = new Router();

		$route = $router->matchRoute( $this->request->requestUri() );

		// Création du namespace complet du controleur
		$controller_name = 'Application\\' . $route['application'] . '\\Controller\\' . $route['controller'] . 'Controller';

		// Si il n'éxiste pas
		if (!class_exists($controller_name)) {
			throw new Exception('Class '. $controller_name . ' doesn\'t exists !');
		}

		foreach ($route['data'] as $key => $value) {
			$_GET[substr($key, 1)] = $value;
		}

		// Instanciation et excecution
		$controller = new $controller_name($this, $route['application'], $route['controller'], $route['action']);
		$controller->execute();
	}

	/**
	 * Méthode d'instanciation et d'éxécution d'un controller donné
	 * @param string $application Le nom de l'application
     * @param string $controller Le nom du controleur
     * @param string $action Le nom de l'action
	 * @return void
	 */
	public function call($application, $controller, $action, $params = array())
	{
		// Création du namespace complet du controleur
		$controller_name = 'Application\\' . $application . '\\Controller\\' . $controller . 'Controller';

		// Si il n'éxiste pas
		if (!class_exists($controller_name)) {
			throw new Exception('Class '. $controller_name . ' doesn\'t exists !');
		}

		foreach ($params as $key => $value) {
			$_GET[$key] = $value;
		}

		$controller = new $controller_name($this, $application, $controller, $action);
		$controller->execute();
	}

	// Méthode de l'interface ArrayAccess pour utiliser l'objet comme un tableau

	/**
	 * Getter d'un attribut
	 * @param string Nom de l'attribut
	 * @return
	 */
	public function offsetGet($var)
	{
		if (isset($this->$var))
		{
			return $this->$var;
		}
	}
	
	/**
	 * Setter d'un attribut
	 * @param string Nom de l'attribut
	 * @param string Valeur
	 * @return
	 */
	public function offsetSet($var, $value)
	{
		throw new Exception('Cannot set property on this object !');
	}
	
	/**
	 * Test l'existance d'un attribut
	 * @param string Nom de l'attribut
	 * @return bool
	 */
	public function offsetExists($var)
	{
		return isset($this->$var);
	}
	
	/**
	 * Supprime un attribut
	 * @param string Nom de l'attribut
	 * @return void
	 */
	public function offsetUnset($var)
	{
		throw new Exception('Cannot unset property on this object !');
	}
}