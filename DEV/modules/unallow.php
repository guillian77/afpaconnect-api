<?php

require_once "Service.php";

/**
 * Class Unfound | fichier Unfound.php
 *
 * List of classes needed for this class :
 *
 * require_once "Service.php";
 *
 * @package Afpanier Project
 * @subpackage service
 * @author @Afpa Lab Team - Guillian Aufrère
 * @copyright  1920-2080 The Afpa Lab Team Group Corporation World Company
 * @version v1.0
 */

Class Unallow {
	
    /**
     * public $resultat is used to store all datas needed for HTML Templates
     * @var array
     */
    public $resultat;

    /**
     * init variables resultat
     *
     * execute main function
     */
    public function __construct() {

        header('HTTP/1.0 403 Forbidden');
        
        // init variables resultat
        $this->resultat = [];

        // execute main function
        $this->main();
    }

    /**
     *
     * Destroy service
     *
     */
    public function __destruct() {
        // destroy objet_service
        unset($objet_service);
    }

    /**
     * Get interface to gestion of accueil
     */
    function main() {
		$objet_service = new Service();
        // call method from service
		
		
        // Retrieve parameters to access in html page
		$this->resultat = $objet_service->resultat;
		$this->VARS_HTML = $objet_service->VARS_HTML;
    }
	
}

?>

