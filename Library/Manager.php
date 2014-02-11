<?php

/**
 * Fichier : /Library/Manager.php
 * Description : Manager de base de données
 * Auteur Thomas Menu
 * Date : 07/12/2013
 */

namespace Library;

use Exception;
use PDO;

class Manager extends ApplicationComponent
{
	protected $dao = null;         // Data Access Object
	protected $managers = array(); // Tableau des managers

	public function getDao()
	{
		// Si l'objet n'est pas instancié
		if ($this->dao === null)
		{
			try {
			    $this->dao = new PDO('mysql:host=' . $this->app['config']['db']['host'] . ';dbname=' . $this->app['config']['db']['base'], $this->app['config']['db']['user'], $this->app['config']['db']['pass']);
			}
			catch (Exception $e) {
			    throw new Exception($e->getMessage());
			}

			$this->dao->query('SET NAMES "utf8"');
		}

		return $this->dao;
	}

	public function getManagerOf($entity)
	{
		if (!isset($this->managers[$entity]))
		{
			$manager_class = 'Model\\Manager\\' . ucfirst(mb_strtolower($entity)) . 'Manager';

			if (!class_exists($manager_class)) {
				throw new Exception('Class '. $manager_class . ' doesn\'t exists !');
			}

			$this->managers[$entity] = new $manager_class( $this->getDao() );
		}

		return $this->managers[$entity];
	}
}