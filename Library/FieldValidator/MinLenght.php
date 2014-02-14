<?php

/**
 * Fichier : /Library/FieldValidator/MinLenght.php
 * Description : Validation longueur minimale d'une chaine
 * Auteur : Thomas Menu
 * Date : 13/02/2014
 */

namespace Library\FieldValidator;

use Library\AbstractClass\FieldValidator;

class MinLenght extends FieldValidator
{
    protected $min_lenght;

    public function __construct($data)
    {
        if (!is_numeric($data['min_lenght'])) {
            throw new InvalidArgumentException('Argument "min_lenght" passed to MinLenght::__construct() must be numeric');
        }

        $this->min_lenght = $data['min_lenght'];
    }

    public function isValid($value)
    {
        return (empty($value) || strlen($value) >= $this->min_lenght);
    }
}