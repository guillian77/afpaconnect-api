<?php
namespace App\Core;

/**
 * Class Database
 */
Class Database {

	/**
	 * @var PDO $_hDb
	 */
	public $_hDb;

	/**
	 * Database constructor.
	 * @param string $host Database hostname.
	 * @param string $name Database name.
	 * @param string $login Database username.
	 * @param string $psw Database password.
	 */
	function __construct($host, $name, $login, $psw)	{
		// Connection to DB : SERVEUR / LOGIN / PASSWORD / NOM_BDD
		try {
			$this->_hDb= new \PDO('mysql:host='.$host.';dbname='.$name.';charset=utf8', $login, $psw);
		} catch (\PDOException $e) {
			echo 'Échec lors de la connexion : ' . $e->getMessage();
		}
	}

	function __destruct()	{
		$this->_hDb= null;
	}

	function prepare($sql) {
		return $this->_hDb->prepare($sql);
	}

	/**
	 * Get last insert ID
	 * @return string lastInsertId
	 */
	public function getLastInsertId()	{
		error_log('getLastInsertId DETAILS = '.$this->_hDb->lastInsertId());
		return $this->_hDb->lastInsertId();
	}

	/**
	 * SQL SELECT query helper
	 * @param string $spathSQL path to sql file
	 * @param array $data
	 * @return array
	 */
	function getSelectDatas(string $query, array $data=array())	{
		// content of SQL file
//		$sql= file_get_contents($spathSQL);

		// replace variables @variable from sql by values of the same variables'name
		foreach ($data as $key => $value) {
            $query = str_replace('@'.$key, $value, $query);
		}

		error_log("getSelectDatas = " . $query);

		// Execute la requete
		$resultats_db= $this->_hDb->prepare($query);
		$resultats_db->execute();

		if (!$resultats_db){
			error_log("error = " . $this->_hDb->error);
		}

		$resultat= [];
		while ($ligne = $resultats_db->fetch()) {
			$new_ligne= [];
			foreach ($ligne as $key => $value) {
				if (!(is_numeric($key)))	{
					$new_ligne[$key]= $value;
				}
			}
			$resultat[]= $new_ligne;
		}

		return $resultat;
	}

	/**
	 * SQL UPDATE/DELETE query helper
	 * @param $spathSQL path to sql file
	 * @param array $data
	 * @return false|PDOStatement
	 */
	function treatDatas($query, $data=array())	{
		// content of SQL file
		// $sql= file_get_contents($spathSQL);


		// replace variables @variable from sql by values of the same variables'name
		foreach ($data as $key => $value) {
			$query= str_replace('@'.$key, $value, $query);
		}

		error_log("treatDatas = " . $query);
		
		// Execute la requete
		$resultats_db= $this->_hDb->query($query);


		if (!$resultats_db){
			error_log("!!! error on treatDatas !!!");
			header('HTTP/1.0 400 Bad request.');
		}

		return $resultats_db;
	}
}
