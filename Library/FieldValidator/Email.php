<?php

/**
 * Fichier : /Library/FieldValidator/Email.php
 * Description : Validation format d'une adresse email
 * Auteur : Thomas Menu
 * Date : 13/02/2014
 */

namespace Library\FieldValidator;

use Library\AbstractClass\FieldValidator;

class Email extends FieldValidator
{
    public function isValid($value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) ? true : false;
    }
}