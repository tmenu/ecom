<?php

/**
 * Fichier : /Library/FieldValidator/File.php
 * Description : Validation si la valeur n'éxiste pas en BDD
 * Auteur : Thomas Menu
 * Date : 13/02/2014
 */

namespace Library\FieldValidator;

use Library\AbstractClass\FieldValidator;
use Library\AbstractClass\Manager;

class File extends FieldValidator
{
    protected $keep_old;             // Conserer l'ancien ichier (s'il y en a un)
    protected $extensions = array(); // Liste des extensions valides
    protected $max_size;             // Taille maximum autorisée

    protected $error_code; // Code erreur en cas d'erreur

    public function __construct(array $data)
    {
        $this->keep_old   = $data['keep_old'];
        $this->extensions = $data['extensions'];
        $this->max_size   = $data['max_size'];
    }

    public function isValid($value)
    {
        // Si pas de fichier et conservation de l'ancien
        if ($this->keep_old && $value['error'] == 4) {
            return true; // Valide
        }
        
        // Sinon test
        if ($value['error'] == 4) // Pas de fichier
        {
            $this->error_code = 'NO_FILE';
            return false;
        }
        else if ($value['error'] != 0) // Erreur
        {
            $this->error_code = 'UNKNOW_ERROR';
            return false;
        }
        else if ($value['size'] > $this->max_size) // Taille maximale
        {
            $this->error_code = 'INVALID_SIZE';
            return false;
        }
        else // Extension
        {
            $extension_upload = strtolower(substr(strrchr($value['name'], '.'), 1));

            if (!in_array($extension_upload, $this->extensions))
            {
                $this->error_code = 'INVALID_EXTENSION';
                return false;
            }
        }

        // Aucune erreur
        return true;
    }

    public function getErrorCode()
    {
        return $this->error_code;
    }
}