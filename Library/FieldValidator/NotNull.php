<?php

/**
 * Fichier : /Library/FieldValidator/NotNull.php
 * Description : Validation champs obligatoire
 * Auteur : Thomas Menu
 * Date : 13/02/2014
 */

namespace Library\FieldValidator;

use Library\AbstractClass\FieldValidator;

class NotNull extends FieldValidator
{
    public function isValid($value)
    {
        return !empty($value);
    }
}