<?php

/**
 * Fichier : /Library/FieldValidator/NotExistsInDb.php
 * Description : Validation si la valeur n'éxiste pas en BDD
 * Auteur : Thomas Menu
 * Date : 13/02/2014
 */

namespace Library\FieldValidator;

use Library\AbstractClass\FieldValidator;
use Library\AbstractClass\Manager;

class NotExistsInDb extends FieldValidator
{
    protected $manager;       // Manager de l'entité
    protected $test_method;   // Méthode pour tester l'attribut de l'entité
    protected $current_value; // Valeur actuelle de l'entité

    public function __construct(array $data)
    {
        $this->manager       = $data['manager'];
        $this->test_method   = $data['test_method'];
        $this->current_value = (isset($data['current_value'])) ? $data['current_value'] : '';
    }

    public function isValid($value)
    {
        if (!method_exists($this->manager, $this->test_method)) {
            throw new \Exception('Method "' . $get_by_method . '" doesn\'t exists');
        }

        // Si on a une valeur actuelle et qu'elle est identique à la valeur testé : pas d'erreur
        if (!empty($this->current_value) && $value == $this->current_value) {
            return true;
        }
        else { // Sinon recherche en BDD si la valeur à tester éxiste
            return ($this->manager->{$this->test_method}($value)) ? false : true;
        }
    }
}