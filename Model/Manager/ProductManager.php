<?php

/**
 * Fichier : /Model/Entity/Product.php
 * Description : Manager des produits
 * Auteur Thomas Menu
 * Date : 10/02/2014
 */

namespace Model\Manager;

use Library\AbstractClass\Manager;
use Library\AbstractClass\Entity;

use Library\Utils;
use Model\Entity\Product;
use DateTime;
use InvalidArgumentException;

class ProductManager extends Manager
{
    public function get($id)
    {
        $q = $this->dao->prepare('SELECT *
                            FROM product
                            WHERE id= :id');

        $q->bindValue(':id', $id, \PDO::PARAM_INT);

        $q->execute();

        if (($result = $q->fetch()) !== false) {
            return new Product($result);
        }
        else {
            return false;
        }
    }

    public function getByName($name)
    {
        $q = $this->dao->prepare('SELECT *
                                  FROM product
                                  WHERE name = :name');

        $q->bindValue(':name', $name);

        $q->execute();

        if (($result = $q->fetch()) !== false) {
            return new Product($result);
        }
        else {
            return false;
        }
    }

    public function getAll()
    {
        $q = $this->dao->prepare('SELECT *
                                  FROM product');

        $q->execute();

        if (($results = $q->fetchAll()) !== false) 
        {
            $products_list = array();

            foreach ($results as $result) {
                $products_list[] = new Product($result);
            }

            return $products_list;
        }
        else {
            return false;
        }
    }

    protected function insert(Entity $product)
    {
        $q = $this->dao->prepare('INSERT INTO product
                                  SET name         = :name,
                                      price        = :price,
                                      date_created = :date_created,
                                      description  = :description,
                                      image        = :image');

        $q->bindValue(':name',         $product->getName());
        $q->bindValue(':price',        $product->getPrice(), \PDO::PARAM_INT);
        $q->bindValue(':date_created', $product->getDate_created(false));
        $q->bindValue(':description',  $product->getDescription());
        $q->bindValue(':image',        $product->getImage());

        $q->execute();

        return $this;
    }

    protected function update(Entity $product)
    {
        $q = $this->dao->prepare('UPDATE product
                                  SET name         = :name,
                                      price        = :price,
                                      date_created = :date_created,
                                      description  = :description,
                                      image        = :image
                                  WHERE id = :id');

        $q->bindValue(':id',           $product->getId(),    \PDO::PARAM_INT);
        $q->bindValue(':name',         $product->getName());
        $q->bindValue(':price',        $product->getPrice(), \PDO::PARAM_INT);
        $q->bindValue(':date_created', $product->getDate_created(false));
        $q->bindValue(':description',  $product->getDescription());
        $q->bindValue(':image',        $product->getImage());

        $q->execute();

        return $this;
    }

    public function delete($id)
    {
        $q = $this->dao->prepare('DELETE FROM product WHERE id = :id');

        $q->bindValue(':id', $id, \PDO::PARAM_INT);

        $q->execute();

        return $this;
    }

    public function installTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS `product` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `name` varchar(128) NOT NULL,
                  `price` int(11) NOT NULL,
                  `date_created` datetime NOT NULL,
                  `description` text NOT NULL,
                  `image` varchar(255) NOT NULL,
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ";

        $this->dao->query($sql);
    }

    public function dummyProducts($number)
    {
        for ($i = 0; $i < $number; $i++)
        {
            $p = new Product();

            $p->setName( Utils::randomLipsum(1, 'words') );
            $p->setPrice( mt_rand(5, 1000) );
            $p->setDate_created(new DateTime( mt_rand(2012, 2013) . '-' . mt_rand(1, 12) . '-' . mt_rand(1, 28) ));
            $p->setDescription( Utils::randomLipsum(1, 'paras') );  
            $p->setImage('/img/contract.png'); 

            $this->insert($p);
        }
    }
}