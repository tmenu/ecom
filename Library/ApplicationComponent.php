<?php

/**
 * Fichier : /Library/ApplicationComponent.php
 * Description : Composant d'application
 * Auteur Thomas Menu
 * Date : 08/12/2013
 */

namespace Library;

class ApplicationComponent
{
	protected $app = null; 

	public function __construct(Application $app)
	{
		$this->app = $app;
	}
}