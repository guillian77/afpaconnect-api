<?php
namespace App\Core;

require_once "database.php";
require_once "security.php";

Class Initialize	{
	/**
	 * @var object $oBdd
	 * @var array $GLOBAL_INI
	 * @var object $oSecu
	 * @var array $VARS_HTML
	 * 
	 */
	// Database instance object
	public $oBdd;
	// All globals from INI
	public $GLOBALS_INI;
	// Form Security instance object
	private $oSecu;
	// Array of data
	public $VARS_HTML;
	

	/**
	 * 
	 * Fill GLOBAL_INI with an array of path variables
	 * Create instance of Security and Database connection 
	 * Set data in public VARS_HTML from Security Object VARS_HTML argument
	 * 
	 */
	public function __construct()	{
		// Instance of Config
		$this->GLOBALS_INI= Configuration::get();

		// Instance of BDD
		$this->oBdd = new Database($this->GLOBALS_INI["db_hostname"],
								   $this->GLOBALS_INI["db_name"],
								   $this->GLOBALS_INI["db_username"],
								   $this->GLOBALS_INI["db_password"]);

		// Instance of Security to have $this->VARS_HTML
		$this->oSecu = new Security();
		$this->VARS_HTML= $this->oSecu->VARS_HTML;

		return $this->oBdd;
	}

	/**
	 * Destroy security Object and Database initialization Object
	 */
	public function __destruct()	{
		// destroy Instance of Form
		unset($this->oSecu);
		// disconnect of BDD
		// destroy Instance of BDD
		unset($this->oBdd);
	}

//End of class
}
