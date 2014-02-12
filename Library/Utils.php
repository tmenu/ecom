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
     * Generate Lorem lipsum
     *
     * @param int $amount = 1 Number of $what
     * @param string $what = 'paras' What you would generate (params, words, bytes, or ???)
     * @param int $start = 0 Start with "Lorem lipsum dolor ..."
     *
     * @return string Generated lipsum
     */
    static public function randomLipsum($amount = 1, $what = 'paras', $start = 0)
    {
        $data = simplexml_load_file('http://www.lipsum.com/feed/xml?amount='.$amount.'&what='.$what.'&start='.$start)->lipsum;
        
        $data = $data->__toString();

        if ($what == 'words') {
            $data = substr($data, 0, strpos($data, ' '));
        }

        return $data;
    }

    /**
     * Generate hash of a string
     *
     * @param string $string Le string to hash
     * @param string $salt = '' Salt to include in hash
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
     * Secure data to output
     *
     * @param string $data Data to secure
     *
     * @return string Data secured
     */
	static public function secure($data)
	{
		return htmlspecialchars($data);
	}

	/**
     * Get a value in $_POST by a key
     *
     * @param string $key The key of the data (like "key.foo.bar" for $_POST['key']['foo']['bar'])
     * @param array $array = array() Array where do the search instead of $_POST if given
     *
     * @return string The value
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
				return Utils::postValue($keys, $array[ $key ]);
			}
			else
			{
				// Sinon renvoi de la valeur finale
				return $array[ $key ];
			}
		}
	}

	/**
     * Generate an URL with a given route name
     *
     * @param string $rout_name The name of the route you would generate
     * @param array $params = array() The params for the URL
     *
     * @return string $url The generated URL
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
     * Translate english days and months into a string in french
     *
     * @param string $date Le string to translate
     *
     * @return string $date The string translated
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

    /**
     * Generate the slug of a string
     *
     * @param string $text The string to slugify
     *
     * @return string $text The string slugified
     */
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

    static public function truncate($text, $chars = 50)
    {
        $text = $text." ";
        $text = substr($text,0,$chars);
        $text = substr($text,0,strrpos($text,' '));
        $text = $text."...";
        return $text;
    }

}