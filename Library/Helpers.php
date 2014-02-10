<?php

/**
 * Fichier : /Library/Utils.php
 * Description : Fonctions d'aides
 * Auteur Thomas Menu
 * Date : 08/12/2013
 */

namespace Library;

class Utils
{
	/**
	 * secureHtml()
	 * Description : Sécurise les caractères HTML pour un affichage.
	 * @param string : La clé de va valeur POST à récupérer (ie : "username" ; "form1.field.username")
	 * @return string : La valeur demandée
	 */
	static public function secureHTML($data)
	{
		return htmlspecialchars($data);
	}

	/**
	 * hashPassword()
	 * Description : Génére le hash d'un mot de passe
	 * @param string Le mot de passe
	 * @return string Le hash du mot de passe
	 */
	static public function hashPassword($password)
	{
		$salt = 'rf!p!WC7fS7L4*Ys$Ps2t6$49Dzw5R)(!2(h9$6V';

		for ($i = 0; $i < 5000; $i++) { 
			$password = hash('sha512', $password);
		}

		return $password;
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
	 * createPsswd()
	 * Description : Génère un mot de passe aléatoire
	 * @param int le nombre de caractères (par défault 6)
	 * @return string mot de passe génèrée
	 */
	static public function createPsswd($nbCara = 6)
	{
		// Liste des caractères disponible
		$chars = "azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN0123456789";
		return $password = substr(str_shuffle($chars), 0, $nbCara);
	}

	/**
	 * makeURL()
	 * Description : Génère une URL à partir d'un nom de route et ses paramètres
	 * @param string Le nom de la route
	 * @param array La liste des paramètres
	 * @return string L'URL générée
	 */
	static public function makeURL($route_name, array $params = array())
	{
		// Si on a pas encore chargé les routes
		if (empty(Library\Router::$routes))
		{
			// Récupération des routes
			//require_once('../config/routes.php');
			self::$routes = json_decode(file_get_contents('../config/routes.json'), true);
		}

		// Si la route demandée n'existe pas
		if (!isset(Library\Router::$routes[$route_name])) {
			throw new Exception('Route '. $route_name . ' doesn\'t exists !');
		}

		// Génération de l'URL
		$route = Library\Router::$routes[$route_name];

		$url = $route['regex'];

		// Mise en place des paramètres fournit
		if (isset($route['params'])) {
			$i = 0;
			foreach ($route['params'] as $key => $regex) {
				$url = str_replace('('.$key.')', $params[$i++], $url);
			}
		}

		return BASE_URL.$url;
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
}