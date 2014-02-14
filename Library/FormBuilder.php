<?php

/**
 * Fichier : /Library/FormBuilder.php
 * Description : Constructeur de formulaire
 * Auteur : Thomas Menu
 * Date : 13/02/2014
 */

namespace Library;

use Library\AbstractClass\Entity;
use Library\Utils;
use Library\FieldType\Hidden;

class FormBuilder
{
    protected $name;
    protected $form_validity;
    protected $action;
    protected $fields = array(); // Tableau des champs du formulaire

    const TOKEN_SUFFIX = '_form_token';

    // Codes erreurs
    CONST FORM_VALID    = 0; // Formulaire valide
    CONST FIELD_ERROR   = 1; // Erreurs de validation sur les champs
    CONST TOKEN_EXPIRE  = 2; // Délais de validité du formulaire expirée
    CONST TOKEN_INVALID = 3; // Token du formulaire invalide

    public function __construct($name, array $form_fields, $action = '', $validity = 1800) // Validité par défaut 30min (1800s)
    {
        $this->name   = $name;
        $this->action = $action;

        // Affectation de la durée de validité du formulaire et création d'un champ pour le token
        $this->form_validity = $validity;
        $this->fields[$this->name . self::TOKEN_SUFFIX] = new Hidden(array('name' => $this->name . self::TOKEN_SUFFIX));

        // Parcours des définitions des champs
        foreach ($form_fields as $field)
        {
            // Test si déjà ajouté
            if (isset($this->fields[$field['name']])) {
                throw new \Exception('Field "' . $field['name'] . '" is already definied');
            }

            // Création du namespace complet du type de champs
            $field_class = 'Library\\FieldType\\' . ucfirst(mb_strtolower($field['type']));

            // Ajout du champ au formulaire
            $this->fields[$field['name']] = new $field_class($field);
        }
    }

    /**
     * Génère le code HTML d'un champs
     *
     * @param void
     * @return string Le code HTML du champs
     */
    public function formStart()
    {
        $head = '<form id="' . $this->name . '" method="post" class="form-horizontal" role="form" action="' . $this->action . '" ';

        foreach ($this->fields as $field)
        {
            if (get_class($field) == 'Library\\FieldType\\File') {
                $head .= 'enctype="multipart/form-data"';
                break;
            }
        }

        return $head . '>';
    }

    /**
     * Génère le code HTML d'un champs
     *
     * @param void
     * @return string Le code HTML du champs
     */
    public function formEnd()
    {
        $form = $this->generateForm();

        return $form . '</form>';
    }

    /**
     * Génère le code HTML d'un champs
     *
     * @param void
     * @return string Le code HTML du champs
     */
    protected function createToken()
    {
        // Création dd'un token pour le formulaire
        $this->fields[$this->name . self::TOKEN_SUFFIX]->setValue( Utils::generateString(50) );

        // Affectation du token à la session
        $_SESSION[$this->name . self::TOKEN_SUFFIX] = array(
            'time'     => time(),
            'validity' => $this->form_validity,
            'key'      => $this->fields[$this->name . self::TOKEN_SUFFIX]->getValue()
        );
    }

    /**
     * Génère le code HTML des champs du formulaire
     *
     * @param void
     * @return string Le code HTML des champs du formulaire
     */
    public function generateForm()
    {
        // Création dd'un token pour le formulaire
        $this->createToken();

        // Génération des champs du formulaire
        $form = '';

        foreach ($this->fields as $field)
        {
            $form .= $field->generateField();
        }

        return $form;
    }

    /**
     * Génère le code HTML d'un champs
     *
     * @param void
     * @return string Le code HTML du champs
     */
    public function generateField($name, $label_width = 4)
    {
        if (!isset($this->fields[$name])) {
            throw new \Exception('Field "' . $name . '" doesn\'t exists');
        }

        if ($name == ($this->name . self::TOKEN_SUFFIX)) {
            // Création dd'un token pour le formulaire
            $this->createToken();
        }
        
        $field = $this->fields[$name]->generateField($label_width);

        unset($this->fields[$name]);

        return $field;
    }

    /**
     * Affecte les valeurs d'un tableau aux champs existants
     *
     * @param void
     * @return void
     */
    public function handleForm(array $values)
    {
        // Parcours des valeurs du tableau fournit
        foreach ($values as $key => $value)
        {
            // Si un champs du même nom existe
            if (isset($this->fields[$key])) {
                $this->fields[$key]->setValue($value); // Affectation de la valeur
            }
        }
    }

    /**
     * Test la validité de chacun des champs du formulaire
     *
     * @param void
     * @return void
     */
    public function isValid()
    {
        // Test du token
        if ($_SESSION[$this->name . self::TOKEN_SUFFIX]['key'] != $this->fields[$this->name . self::TOKEN_SUFFIX]->getValue()) {
            return self::TOKEN_INVALID;
        }
        else if ($_SESSION[$this->name . self::TOKEN_SUFFIX]['time'] < (time() - $_SESSION[$this->name . self::TOKEN_SUFFIX]['validity'])) {
            return self::TOKEN_EXPIRE;
        }

        // Test des champs
        $result = self::FORM_VALID; // Par defaut : pas d'erreur

        // Parcours des champs
        foreach ($this->fields as $field)
        {
            // Si le hamps n'est pas valide
            if ($field->isValid() === false) {
                $result = self::FIELD_ERROR; // On passe la validité à faux (les champs suivants seront tout de même vérifiés pour générer les éventuelles messages d'erreur)
            }
        }

        // Renvoi du résultat
        return $result;
    }

    public function getField($name)
    {
        if (!isset($this->fields[$name])) {
            throw new \Exception('Field "' . $name . '" doesn\'t exists');
        }

        return $this->fields[$name];
    }
}