<?php

/**
 * Fichier : /Library/Utils.php
 * Description : Fonctions d'aides
 * Auteur Thomas Menu
 * Date : 10/02/2014
 */

namespace Library;

use Exception;

class Utils
{
	/**
     * Generate random string
     *
     * @param int $length = 10 Lenght of the string to generate
     *
     * @return string Generated string
     */
    static public function generateString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $random_string = '';

        for ($i = 0; $i < $length; $i++) {
            $random_string .= $characters[mt_rand(0, strlen($characters) - 1)];
        }

        return $random_string;
    }

    /**
     * Generate random string
     *
     * @param int $length = 10 Lenght of the string to generate
     *
     * @return string Generated string
     */
    static public function randomLipsum($amount = 1, $what = 'paras', $start = 0)
    {
        $data = simplexml_load_file('http://www.lipsum.com/feed/xml?amount='.$amount.'&what='.$what.'&start='.$start)->lipsum;
    
        if ($what = 'words') {
            $data = substr($data, 0, strpos($data, ' '));
        }

        return $data;
    }

    /**
     * Generate hash of a string
     *
     * @param void
     *
     * @return string String hashed
     */
    static public function hashString($string, $salt = '')
    {
        for ($i = 0; $i < 50000; $i++) {
            $string = hash('sha512', $string.$salt);
        }

        return $string;
    }

	/**
	 * secure()
	 * Description : Sécurise les caractères HTML pour un affichage.
	 * @param string : La clé de va valeur POST à récupérer (ie : "username" ; "form1.field.username")
	 * @return string : La valeur demandée
	 */
	static public function secure($data)
	{
		return htmlspecialchars($data);
	}

	/**
	 * postValue()
	 * Description : Récupère des données dans le tableau $_POST
	 * @param string La clé de la données à récupérer
	 * @param array Le tableau dans lequel effectuer la recherche (pour une utilisation recursive)
	 * @return string La données de demandée
	 */
	static public function postValue($keys, $array = array())
	{
		// Si pas de tableau en argument : utilisation du tableau POST
		if (empty($array)) { 
			$array = $_POST; 
		}

		// Recherche position premier "."
		$end = (strpos($keys, '.') !== false) ? strpos($keys, '.') : strlen($keys);
		// Extraction première clé
		$key = substr($keys, 0, $end);

		// Si la clé existe
		if (isset($array[ $key ]))
		{
			// Si elle contient un array
			if (is_array($array[ $key ]))
			{
				// Extraction clés suivantes
				$keys = substr(strstr($keys, '.'), 1);

				// Test suivant
				return postValue($keys, $array[ $key ]);
			}
			else
			{
				// Sinon renvoi de la valeur finale
				return $array[ $key ];
			}
		}
	}

	/**
	 * generateUrl()
	 * Description : Génère une URL à partir d'un nom de route et ses paramètres
	 * @param string Le nom de la route
	 * @param array La liste des paramètres
	 * @return string L'URL générée
	 */
	static public function generateUrl($route_name, array $params = array())
	{
		$routes = json_decode(file_get_contents(dirname(__DIR__) . '/config/routes.json'), true);
        
		// Si la route demandée n'existe pas
		if (!$routes[$route_name]) {
			throw new Exception('Route '. $route_name . ' doesn\'t exists !');
		}

		// Génération de l'URL
		$route = $routes[$route_name];

		$url = $route['regex'];

		// Mise en place des paramètres fournit
		if (isset($route['params'])) {
			$i = 0;
			foreach ($route['params'] as $key => $regex) {
				$url = str_replace('('.$key.')', $params[$i++], $url);
			}
		}

		return $url;
	}

	/**
	 * translateMySQLDate()
	 * Description : Traduit jours/mois d'une date MySQL (http://dev.mysql.com/doc/refman/5.0/fr/date-and-time-functions.html#idm47771644203616)
	 * @param string Date
	 * @return string Date avec noms des jours/mois en francais
	 */
	static public function translateDate($date)
	{
		$trans = array(
			'January'   => 'Janvier',
			'Febuary'   => 'Févier',
			'March'     => 'Mars',
			'April'     => 'Avril',
			'May'       => 'Mai',
			'June'      => 'Juin',
			'July'      => 'Juillet',
			'August'    => 'Août',
			'September' => 'Septembre',
			'October'   => 'Octobre',
			'November'  => 'Novembre',
			'December'  => 'Decembre',


			'Jun' => 'Jan',
			'Feb' => 'Fév',
			'Mar' => 'Mar',
			'Apr' => 'Avr',
			'May' => 'Mai',
			'Jun' => 'Juin',
			'Jul' => 'Juil',
			'Aug' => 'Aoû',
			'Sep' => 'Sep',
			'Oct' => 'Oct',
			'Nov' => 'Nov',
			'Dec' => 'Dec',


			'Monday'    => 'Lundi',
			'Tuesday'   => 'Mardi',
			'Wednesday' => 'Mercredi',
			'Thursday'  => 'Jeudi',
			'Friday'    => 'Vendredi',
			'Saturday'  => 'Samedi',
			'Sunday'    => 'Dimanche',


			'Mon' => 'Lun',
			'Tue' => 'Mar',
			'Wed' => 'Mer',
			'Thu' => 'Jeu',
			'Fri' => 'Ven',
			'Sat' => 'Sam',
			'Sun' => 'Dim',
		);

		return str_replace(array_keys($trans), array_values($trans), $date);
	}

	static public function datetime2Timestamp($date)
	{
		if (empty($date) || $date == ' 00:00') {
			return 0;
		}
		else {
			return mktime((int)substr($date, 11, 2), (int)substr($date, 14, 2), 0, (int)substr($date, 5, 2), (int)substr($date, 8, 2), (int)substr($date, 0, 4));
		}
	}

    static public function slugify($text)
    { 
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

        // trim
        $text = trim($text, '-');

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        if (empty($text))
        {
        return 'n-a';
        }

        return $text;
    }
}