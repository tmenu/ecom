<?php

/**
 * Fichier : /Library/AbstractClass/FieldType.php
 * Description : Modèle d'un type de champ pour formulaire
 * Auteur : Thomas Menu
 * Date : 10/02/2014
 */

namespace Library\AbstractClass;

abstract class FieldType
{
    protected $name;                // Nom du champs 
    protected $label;               // Libéllé du champs
    protected $value;               // Valeur
    protected $help_text;           // Message d'aide

    protected $rules = array();     // Régles de validation
    protected $error_message;       // Message d'erreur (si erreur de validation)

    public function __construct(array $data)
    {
        // Initialisation des attributs
        $this->name      = $data['name'];
        $this->label     = (isset($data['label'])) ? $data['label'] : '';
        $this->value     = (isset($data['value'])) ? $data['value'] : '';
        $this->help_text = (isset($data['help_text'])) ? $data['help_text'] : '';

        $this->rules     = (isset($data['rules'])) ? $data['rules'] : array();
    }

    /**
     * Génère le code HTML du champ (à developper pour chaque type de champ)
     *
     * @param void
     * @return string Le code HML du champ
     */
    abstract public function generateField();

    /**
     * Test la validité du champ en fonction des régles déinies
     *
     * @param void
     * @return void
     */
    public function isValid()
    {
        // Parcours des règles
        foreach ($this->rules as $validator_name => $rules)
        {
            // Création du namespace du validateur
            $validator_class = 'Library\\FieldValidator\\' . $validator_name;

            if (!isset($rules['data'])) {
                $rules['data'] = array();
            }

            // Instanciation du validateur en lui passant les paramètres fournit
            $validator = new $validator_class( $rules['data'] );

            // Si le champs ne respecte pas cette validation
            if (($validator->isValid( $this->value )) === false)
            {
                // Si la liste des erreurs est un tableau
                if (is_array($rules['error']))
                {
                    // Affectation de l'erreur correspondante
                    $this->error_message = $rules['error'][ $validator->getErrorCode() ]; 
                }
                else
                {
                    // Affectation de l'erreur
                    $this->error_message = $rules['error']; 
                }

                return false; // Arrêt du test
            }
        }

        // Aucune erreur
        return true;
    }

    public function setValue($value) {
        $this->value = $value;

        return $this;
    }

    public function getValue() {
        return $this->value;
    }
}