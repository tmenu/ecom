<?php

/**
 * Fichier : /Library/ApplicationComponent/Session.php
 * Description : Gestion de la session utilisateur
 * Auteur Thomas Menu
 * Date : 08/12/2013
 */

namespace Library\ApplicationComponent;

use Library\AbstractClass\ApplicationComponent;

class Session extends ApplicationComponent
{
	public function __construct()
	{
		// SI la session n'est pas active : on l'a lance
		if (session_id() === '') {
			session_start();
		}

		// SI la session n'est pas initialisé
		if (!isset($_SESSION['auth'])) {
			$this->setAuth(false);
			$this->setAttr('id',       0);
			$this->setAttr('username', '');
			$this->setAttr('email',    '');
			$this->setAttr('roles',    array('NOT_CONNECTED'));
		}
	}

	public function isAuth()
	{
		return $_SESSION['auth'];
	}

	public function setAuth($bool)
	{
		$_SESSION['auth'] = $bool;
	}

	public function getAttr($key)
	{
		return $_SESSION[$key];
	}

	public function setAttr($key, $value)
	{
		$_SESSION[$key] = $value;
	}

	public function hasRole($role)
	{
		return in_array($role, $_SESSION['roles']);
	}

	/**
	 * Méthode : setFlashMessage()
	 * Description : Définit un message flash qui sera affiché sur la prochaine page
	 * @param string : Le type de message (danger, success, warning, info)
	 * @param string : Le message
	 * @return void
	 */
	public function setFlashMessage($type, $message)
	{
		$_SESSION['flash_messages'][] = array(
			'type' => $type, 
			'message' => $message
		);
	}

	/**
	 * Méthode : getFlashMessage()
	 * Description : Récupère les messages flash
	 * @param void
	 * @return array La liste des messages flash
	 */
	public function getFlashMessage()
	{
		if (!isset($_SESSION['flash_messages'])) {
			return false;
		}

		$tmp = $_SESSION['flash_messages'];
		unset($_SESSION['flash_messages']);

		return $tmp;
	}
}