<?php

/**
 * Fichier : /Model/Entity/Product.php
 * Description : Manager des produits
 * Auteur Thomas Menu
 * Date : 10/02/2014
 */

namespace Model\Manager;

use Library\Utils;
use Library\AbstractManager;
use Library\AbstractEntity;
use Model\Entity\Product;
use DateTime;
use InvalidArgumentException;

class ProductManager extends AbstractManager
{
    public function select($id)
    {
        $q = $this->dao->prepare('SELECT id, name, price, date_created
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

    public function selectByName($name)
    {
        if (!is_string($name)) {
            throw new InvalidArgumentException('$name must be a string');
        }

        $q = $this->dao->prepare('SELECT id, name, price, date_created
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

    public function selectAll()
    {
        $q = $this->dao->prepare('SELECT id, name, price, date_created
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

    public function insert(AbstractEntity $product)
    {
        $q = $this->dao->prepare('INSERT INTO product
                                  SET name         = :name,
                                      price        = :price,
                                      date_created = :date_created');

        $q->bindValue(':name',         $product->getName());
        $q->bindValue(':price',        $product->getPrice(), \PDO::PARAM_INT);
        $q->bindValue(':date_created', $product->getDate_created(false));

        $q->execute();

        return $this;
    }

    public function update(AbstractEntity $product)
    {
        $q = $this->dao->prepare('UPDATE product
                                  SET name         = :name,
                                      price        = :price,
                                      date_created = :date_created
                                  WHERE id = :id');

        $q->bindValue(':id',           $product->getId(),    \PDO::PARAM_INT);
        $q->bindValue(':name',         $product->getName());
        $q->bindValue(':price',        $product->getPrice(), \PDO::PARAM_INT);
        $q->bindValue(':date_created', $product->getDate_created(false));

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
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

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

           $this->insert($p);
        }
    }
}