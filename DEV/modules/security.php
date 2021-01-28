<?php

/**
 * Class Security | file security.php
 *
 * In this class, we find all about security
 *
 * List of classes needed for this class
 * no required class
 *
 * @package AfpaTicket Project
 * @subpackage AfpaTicket
 * @author @Afpa Lab Team
 * @copyright  1920-2080 The Afpa Lab Team Group Corporation World Company
 * @version v1.0
 */

class Security {
	
	/**
	 * Verify $_GET and $_POST
	 * Create a new public variable $VARS_HTML filtered by htmlspecialchars
	 * Contain all request data (GET OR POST) 
	 *
	 * @var array $VARS_HTML
	 */
	public $VARS_HTML;

	function __construct()	{
		$this->VARS_HTML= [];

		/**
		 * Get data from AXIOS (ajax librarie)
		 */
		$axios = json_decode(file_get_contents("php://input"), true);

		/**
		 * Filter arrays
		 */
		if ($axios) {
			array_walk_recursive($axios, 'security::filter');
		} else {
			$axios = [];
		}

		array_walk_recursive($_POST, 'security::filter');
		array_walk_recursive($_GET, 'security::filter');
		array_walk_recursive($_SESSION, 'security::filter');

		/**
		 * Merge arrays
		 */
		$this->VARS_HTML = array_merge($axios, $_POST, $_GET, $_SESSION);
	}

	public static function filter(&$value) {
        $value = htmlspecialchars($value);
    }
}
