<?php

/**
 * Fichier : /Library/FieldType/Button.php
 * Description : Bouton de validation d'un formulaire
 * Auteur : Thomas Menu
 * Date : 13/02/2014
 */

namespace Library\FieldType;

use Library\AbstractClass\FieldType;

class Button extends FieldType
{
    public function generateField()
    {
        $widget  = '<div class="form-group">';
        $widget .= '<div class="col-sm-offset-5 col-sm-7">';
        $widget .= '<button type="submit" class="btn btn-primary">' . $this->label . '</button>';
        $widget .= '</div></div>';

        return $widget;
    }
}