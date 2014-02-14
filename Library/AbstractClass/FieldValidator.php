<?php

/**
 * Fichier : /Library/AbstractClass/FieldValidator.php
 * Description : Modèle d'un validateur de champ de formulaire
 * Auteur : Thomas Menu
 * Date : 10/02/2014
 */

namespace Library\AbstractClass;

abstract class FieldValidator
{
    abstract public function isValid($value);
}