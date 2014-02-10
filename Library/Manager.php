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
	protected $dao = null;

	public function getPDO()
	{
		// Si l'objet n'est pas instancié
		if ($this->dao === null)
		{
			try {
			    $this->dao = new PDO('mysql:host='.DB_HOST.';dbname='.DB_BASE, DB_USER, DB_PASSWORD);
			}
			catch (Exception $e) {
			    throw new Exception($e->getMessage());
			}

			$this->dao->query('SET NAMES "utf8"');
		}

		return $this->dao;
	}
}