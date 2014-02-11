<?php

/**
 * Fichier : /Library/Entity.php
 * Description : Modèle d'une entité
 * Auteur : Thomas Menu
 * Date : 10/02/2014
 */

namespace Library;

abstract class AbstractEntity
{
    protected $id;

    public function __construct(array $data)
    {
        $this->hydrate($data);
    }

    private function hydrate(array $data)
    {
        foreach ($data as $key => $value)
        {
            $method = 'set' . ucfirst($key);

            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    /**
     * Gets the value of id.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the value of id.
     *
     * @param mixed $id the id
     *
     * @return self
     */
    public function setId($id)
    {
        if (!is_numeric($id) && $id !== NULL) {
            throw new InvalidArgumentException('$id must be numeric');
        }

        $this->id = $id;

        return $this;
    }
}