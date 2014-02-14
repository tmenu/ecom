<?php

/**
 * Fichier : /Library/FieldType/Textarea.php
 * Description : Champs de type texarea
 * Auteur : Thomas Menu
 * Date : 14/02/2014
 */

namespace Library\FieldType;

use Library\AbstractClass\FieldType;

class Textarea extends FieldType
{
    public function generateField($label_width = 4)
    {
        $widget  = '<div class="form-group ' . ((!empty($this->error_message)) ? 'has-error' : '') . '">';

        $widget .= '<label for="' . $this->name . '" class="col-sm-' . $label_width . ' control-label">' . $this->label;

        if (isset($this->rules['NotNull'])) {
            $widget .= ' * ';
        }

        $widget .= '</label>';

        $widget .= '<div class="col-sm-' . (12 - $label_width) . '">';
        $widget .= '<textarea name="' . $this->name . '" id="' . $this->name . '" class="form-control" placeholder="' . $this->label . '"';

        if (isset($this->rules['NotNull'])) {
            //$widget .= 'required';
        }

        $widget .= '>';

        if (!empty($this->value)) {
            $widget .= $this->value;
        }

        $widget .= '</textarea>';

        if (!empty($this->error_message)) {
            $widget .= '<div class="help-block">' . $this->error_message . '</div>';
        }

        if (!empty($this->help_text)) {
            $widget .= '<div class="help-block">' . $this->help_text . '</div>';
        }

        $widget .= '</div></div>';

        return $widget;
    }
}