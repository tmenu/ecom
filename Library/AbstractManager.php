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

    abstract public function get($id);
    abstract public function getAll();

    public function save(AbstractEntity $entity)
    {
        // Si l'entité n'a pas d'identifiant : nouvel enregistrement
        if ($entity->getId() === null)
        {
            $this->insert($entity);
        }
        else // Sinon mise à jour
        {
            $this->update($entity);
        }
    }

    abstract protected function insert(AbstractEntity $entity);
    abstract protected function update(AbstractEntity $entity);

    abstract public function delete($id);
}