<?php

/**
 * Fichier : /Library/Entity.php
 * Description : Modèle d'une entité
 * Auteur : Thomas Menu
 * Date : 10/02/2014
 */

namespace Library;

use ArrayAccess; // Pour utiliser l'objet comme un tableau

abstract class AbstractEntity implements ArrayAccess
{
    protected $id;

    public function __construct(array $data = array())
    {
        $this->hydrate($data);
    }

    public function isNew()
    {
        return ($this->id === null) ? true : false;
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

    // Méthode de l'interface ArrayAccess pour utiliser l'objet comme un tableau

    /**
     * Getter d'un attribut
     * @param string Nom de l'attribut
     * @return
     */
    public function offsetGet($var)
    {
        $method = 'get' . ucfirst(mb_strtolower($var));

        if (method_exists($this, $method))
        {
            return $this->$method();
        }
    }
    
    /**
     * Setter d'un attribut
     * @param string Nom de l'attribut
     * @param string Valeur
     * @return
     */
    public function offsetSet($var, $value)
    {
        throw new Exception('Cannot set property on this object !');
    }
    
    /**
     * Test l'existance d'un attribut
     * @param string Nom de l'attribut
     * @return bool
     */
    public function offsetExists($var)
    {
        return isset($this->$var);
    }
    
    /**
     * Supprime un attribut
     * @param string Nom de l'attribut
     * @return void
     */
    public function offsetUnset($var)
    {
        throw new Exception('Cannot unset property on this object !');
    }
}