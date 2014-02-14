<?php

/**
 * Fichier : /Library/FieldValidator/Number.php
 * Description : Validation d'un nombre
 * Auteur : Thomas Menu
 * Date : 13/02/2014
 */

namespace Library\FieldValidator;

use Library\AbstractClass\FieldValidator;

class Number extends FieldValidator
{
    public function isValid($value)
    {
        return is_numeric($value);
    }
}