<?php

/**
 * Fichier : /Library/FieldType/Hidden.php
 * Description : Champs de type hidden
 * Auteur : Thomas Menu
 * Date : 13/02/2014
 */

namespace Library\FieldType;

use Library\AbstractClass\FieldType;

class Hidden extends FieldType
{
    public function generateField()
    {
        $widget = '<input type="hidden" name="' . $this->name . '" value="' . $this->value . '" />';

        return $widget;
    }
}