<?php

/**
 * Fichier : /Library/FieldType/File.php
 * Description : Champs de type texarea
 * Auteur : Thomas Menu
 * Date : 14/02/2014
 */

namespace Library\FieldType;

use Library\AbstractClass\FieldType;

class File extends FieldType
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

            $widget .= '<div class="clearfix">';

                $widget .= '<div class="btn btn-default btn-file pull-left">';
                    $widget .= '<span class="glyphicon glyphicon-picture"></span> Parcourir <input type="file" name="' . $this->name . '" id="' . $this->name . '">';
                $widget .= '</div>';

                $widget .= '<div class="file-title pull-left">N/A</div>';

              $widget .= '</div>';

            if (isset($this->rules['NotNull'])) {
                //$widget .= 'required';
            }

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