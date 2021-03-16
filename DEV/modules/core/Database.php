<?php
namespace App\Core;

use PDO;

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

        return $resultats_db->fetchAll(PDO::FETCH_ASSOC);

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
		// replace variables @variable from sql by values of the same variables'name
		foreach ($data as $key => $value) {
			$query= str_replace('@'.$key, $value, $query);
		}

		error_log("treatDatas = " . $query);

		// Execute la requete
		$resultats_db= $this->_hDb->query($query);

		if (!$resultats_db){
			error_log("!!! error on treatDatas !!!");
			return false;
		}

		return $resultats_db;
	}

    /**
     * Bind query parameters with the query.
     *
     * @param string $query
     * @param array $parameters
     * @return string
     */
    public function bindParameters(string $query, array $parameters):string
    {
        foreach ($parameters as $key => $parameter)
        {
            $query = str_replace('@'.$key, $parameter, $query);
        }

        return $query;
    }
}