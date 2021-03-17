<?php
namespace App\Core;

use PDO;

/**
 * Class Database : Singleton
 *
 * @package App\Core
 *
 * @author Aufrère Guillian
 */
Class Database
{
    /** @var Database $_instance */
    private static $_instance;

    /** @var PDO $_hDb */
    public $_hDb;

    /**
     * Create an instance of Database.
     *
     * @return Database
     */
    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new Database();
        }
        return self::$_instance;
    }

	public function __construct()
    {
		try {
		    $conf = (App::getInstance())->configuration();

			$this->_hDb= new \PDO('mysql:host='.$conf["db_hostname"].';dbname='.$conf["db_name"].';charset=utf8', $conf["db_username"], $conf["db_password"]);
		} catch (\PDOException $e) {
			echo 'Échec lors de la connexion : ' . $e->getMessage();
		}
	}

	public function __destruct()
    {
		$this->_hDb= null;
	}

	public function prepare($sql)
    {
		return $this->_hDb->prepare($sql);
	}

	/**
	 * Get last ID inserted in database.
     *
	 * @return string Last ID inserted in database.
	 */
	public function getLastInsertId()
    {
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
