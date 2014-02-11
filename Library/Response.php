<?php

/**
 * Fichier : /Library/Response.php
 * Description : Gestion requète HTTP 
 * Auteur Thomas Menu
 * Date : 07/12/2013
 */

namespace Library;

use Exception;

class Response extends ApplicationComponent
{
	protected $layout_path;      // Chemin du layout
	protected $css    = array(); // Fichers CSS à include à la page
	protected $js     = array(); // Fichers JS à include au début page
	protected $js_end = array(); // Fichers JS à include à la fin page
	protected $vars   = array(); // Variables à assigner à la vue

	/**
     * Initialise le réponse
     * @param void
     * @return void
     */
	public function __construct(Application $app)
	{
		parent::__construct($app);

		// Ajout des fichiers CSS et JS définit dans le fichier de configuration
		$this->css    = $this->app['config']['css'];
		$this->js     = $this->app['config']['js'];
		$this->js_end = $this->app['config']['js_end'];
	}

	/**
     * Définit la layout à utilisé
     * @param string Le chemin du layout
     * @return void
     */
	public function setLayout($layout_path)
	{
		// Si le layout n'existe pas
		if (!file_exists($layout_path)) {
			throw new Exception('File '. $layout_path . ' doesn\'t exists !');
		}

		$this->layout_path = $layout_path;
	}

	/**
     * Ajoute une variable pour la vue
     * @param string Le nom de la variable
     * @param string Le valeur de la variable
     * @return void
     */
	public function addVar($name, $value)
	{
		$this->vars[$name] = $value;
	}

	/**
     * Ajoute un fichier CSS à la page
     * @param string Le chemin du fichier CSS
     * @return void
     */
	public function addCss($file)
	{
		$this->css[] = $file;
	}

	/**
     * Ajoute un fichier JS au début
     * @param string Le chemin du fichier JS
     * @return void
     */
	public function addJs($file)
	{
		$this->js[] = $file;
	}

	/**
     * Ajoute un fichier JS à la fin ébut
     * @param string Le chemin du fichier JS
     * @return void
     */
	public function addJsEnd($file)
	{
		$this->js_end[] = $file;
	}

	/**
     * Ajoute un header à la réponse HTTP
     * @param string Le header
     * @return void
     */
	public function addHeader($header)
	{
		header($header);
	}
	
	/**
     * Redirige vers une route donnée
     * @param obj Route La route où redirigé
     * @return void
     */
	public function redirect($route_name, array $params = array())
	{
		$uri = Utils::generateUrl($route_name, $params);

		header('Location: '.$uri);
		exit;
	}
	
	/**
     * Redirige vers une erreur 404
     * @param void
     * @return void
     */
	public function redirect404()
	{
		$this->addCss('styles.css');
		$this->setLayout(dirname(__DIR__) . '/View/layout.php');
		$this->renderTemplate(dirname(__DIR__) . '/errors/404.html');
	}

	/**
     * Génére et envoi la page finale
     * @param obj Route La route où redirigé
     * @return void
     */
	public function render($view)
	{
		// Si la vue n'existe pas
		if (!file_exists($view)) {
			throw new Exception('File '. $view . ' doesn\'t exists !');
		}

		// Extraction des variables à passer à la vue
		extract($this->vars);
		$css_files     = $this->css;
		$js_files      = $this->js;
		$js_end_files  = $this->js_end;

		// Include de la vue
		ob_start();
		include $view;
		$__CONTENT = ob_get_clean();

		// Include du layout
		include $this->layout_path;
		exit;
	}
}