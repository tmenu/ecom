<?php

/**
 * Fichier : /Library/Request.php
 * Description : Gestion requète HTTP 
 * Auteur Thomas Menu
 * Date : 07/12/2013
 */

namespace Library;

class Request extends ApplicationComponent
{
    /**
     * Retourne l'URL de la requète
     * @param void
     * @return string
     */
	public function requestUri()
	{
		return $_SERVER['REQUEST_URI'];
	}
	
    /**
     * Retourne la méthode de la requète
     * @param void
     * @return string
     */
	public function method()
	{
		return $_SERVER['REQUEST_METHOD'];
	}
}