<?php

/**
 * Fichier : /Library/Application.php
 * Description : Classe principale
 * Auteur Thomas Menu
 * Date : 07/12/2013
 */

namespace Library;

use Exception;
use ArrayAccess; // Pour utiliser l'objet comme un tableau

class Application implements ArrayAccess
{
	protected $config   = array(); // Tableau des données de config

	protected $route    = null;    // Objet Route correspondant à la route actuelle
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
		$this->manager  = new Manager($this);
		$this->session  = new Session($this);

		// Recherche de la route demandée
		$router = new Router();

		$this->route = $router->matchRoute( $this->request->requestUri() );
	}

	/**
	 * Méthode d'instanciation du contrôleur
	 * @param void
	 * @return void
	 */
	public function run()
	{
		// Création du namespace complet du controleur
		$controller_name = 'Application\\' . $this->route['application'] . '\\Controller\\' . $this->route['controller'] . 'Controller';

		// Si il n'éxiste pas
		if (!class_exists($controller_name)) {
			throw new Exception('Class '. $controller_name . ' doesn\'t exists !');
		}

		// Instanciation et excecution
		$controller = new $controller_name($this);
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