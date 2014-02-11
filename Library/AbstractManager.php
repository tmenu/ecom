<?php

/**
 * Fichier : /Library/AbstractManager.php
 * Description : Controleur des produits
 * Auteur : Thomas Menu
 * Date : 10/02/2014
 */

namespace Library;

use PDO;
use Library\AbstractEntity;

abstract class AbstractManager
{
    protected $dao = null;

    public function __construct(PDO $dao)
    {
        $this->dao = $dao;
    }

    abstract public function select($id);
    abstract public function selectAll();

    abstract public function insert(AbstractEntity $entity);
    abstract public function update(AbstractEntity $entity);
    abstract public function delete($id);
}