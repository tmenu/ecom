<?php

/**
 * Fichier : /Library/FieldValidator/MaxLenght.php
 * Description : Validation longueur maximale d'une chaine
 * Auteur : Thomas Menu
 * Date : 13/02/2014
 */

namespace Library\FieldValidator;

use Library\AbstractClass\FieldValidator;

class MaxLenght extends FieldValidator
{
    protected $max_lenght;

    public function __construct($data)
    {
        if (!is_numeric($data['max_lenght'])) {
            throw new InvalidArgumentException('Argument "max_lenght" passed to MaxLenght::__construct() must be numeric');
        }

        $this->max_lenght = $data['max_lenght'];
    }

    public function isValid($value)
    {
        return strlen($value) <= $this->max_lenght;
    }
}