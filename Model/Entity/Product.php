<?php

/**
 * Fichier : /Model/Entity/Product.php
 * Description : Entité produit
 * Auteur Thomas Menu
 * Date : 10/02/2014
 */

namespace Model\Entity;

use Library\AbstractEntity;
use DateTime;

class Product extends AbstractEntity
{
    protected $name;
    protected $price;
    protected $date_created;

    public function __construct($data = array())
    {
        parent::__construct($data);

        $this->setDate_created(new DateTime());
    }
    
    /**
     * Gets the value of name.
     *
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the value of name.
     *
     * @param mixed $name the name
     *
     * @return self
     */
    public function setName($name)
    {
        if (!is_string($name)) {
            throw new InvalidArgumentException('$name must be a string');
        }

        $this->name = $name;

        return $this;
    }

    /**
     * Gets the value of price.
     *
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Sets the value of price.
     *
     * @param mixed $price the price
     *
     * @return self
     */
    public function setPrice($price)
    {
        if (!is_numeric($price)) {
            throw new InvalidArgumentException('$price must be numeric');
        }

        $this->price = $price;

        return $this;
    }

    /**
     * Gets the value of date_created.
     *
     * @return mixed
     */
    public function getDate_created($sql = true)
    {
        if ($sql === true) {
            return $this->date_created->format('d/m/Y H:i:s');
        }
        else {
            return $this->date_created->format('Y/m/d H:i:s');
        }
    }

    /**
     * Sets the value of date_created.
     *
     * @param mixed $date_created the date_created
     *
     * @return self
     */
    public function setDate_created($date_created)
    {
        if (is_string($date_created)) {
            $date_created = new DateTime($date_created);
        }
        
        $this->date_created = $date_created;

        return $this;
    }
}