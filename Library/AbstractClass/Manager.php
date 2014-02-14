<?php

/**
 * Fichier : /Library/AbstractClass/Manager.php
 * Description : Modèle d'un manager d'entité
 * Auteur : Thomas Menu
 * Date : 10/02/2014
 */

namespace Library\AbstractClass;

use Library\AbstractClass\Entity;

abstract class Manager
{
    protected $dao = null;

    public function __construct(\PDO $dao)
    {
        $this->dao = $dao;
    }

    abstract public function get($id);
    abstract public function getAll();

    public function save(Entity $entity)
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

    abstract protected function insert(Entity $entity);
    abstract protected function update(Entity $entity);

    abstract public function delete($id);
}