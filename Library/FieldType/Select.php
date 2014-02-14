<?php

/**
 * Fichier : /Library/FieldType/Select.php
 * Description : Champs de type text
 * Auteur : Thomas Menu
 * Date : 13/02/2014
 */

namespace Library\FieldType;

use Library\AbstractClass\FieldType;

class Select extends FieldType
{
    protected $choices = array();
    protected $multiple;
    protected $size;

    public function __construct(array $data)
    {
        parent::__construct($data);

        $this->choices  = $data['choices'];
        $this->multiple = (isset($data['multiple'])) ? $data['multiple'] : false;
        $this->size     = (isset($data['size'])) ? $data['size'] : 5;
    }

    public function generateField($label_width = 4)
    {
        $widget  = '<div class="form-group ' . ((!empty($this->error_message)) ? 'has-error' : '') . '">';

        $widget .= '<label for="' . $this->name . '" class="col-sm-' . $label_width . ' control-label">' . $this->label;

        if (isset($this->rules['NotNull'])) {
            $widget .= ' * ';
        }

        $widget .= '</label>';

        $widget .= '<div class="col-sm-' . (12 - $label_width) . '">';
        $widget .= '<select class="form-control" id="' . $this->name . '" name="' . $this->name;

        if ($this->multiple) {
            $widget .= '[]';
        }

        $widget .= '" ';

        if (isset($this->rules['NotNull'])) {
            //$widget .= 'required ';
        }

        if ($this->multiple) {
            $widget .= 'multiple ';

            if (!empty($this->size)) {
                $widget .= 'size="' . $this->size . '" ';
            }
        }

        $widget .= '>';

        foreach ($this->choices as $key => $value)
        {
            $widget .= '<option value="' . $key . '"';

            if (in_array($key, $this->value)) {
                $widget .= ' selected';
            }

            $widget .= '>' . $value . '</option>';
        }

        $widget .= '</select>';

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