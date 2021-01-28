<?php

require_once "initialize.php";

/**
 * Class service | file service.php
 *
 * In this class, we have methods for :
 *
 * With this interface, we'll be able to ....... please describe
 *
 * List of classes needed for this class
 *
 * require_once "initialize.php";
 *
 * @package AfpaCar Project
 * @subpackage Initialize
 * @author @Afpa Lab Team - Prenom Nom stagiaire
 * @copyright  1920-2080 The Afpa Lab Team Group Corporation World Company
 * @version v1.0
 */
class Service extends Initialize {

    /**
     * public $resultat is used to store all datas needed for HTML Templates
     * @var array
     */
    public $resultat;

    /**
     * Call the parent constructor
     *
     * init variables resultat
     */
    public function __construct() {
        // Call Parent Constructor
        parent::__construct();

        // init variables resultat
        $this->resultat = [];
    }

    /**
     * Call the parent destructor
     */
    public function __destruct() {
        // Call Parent destructor
        parent::__destruct();
    }

}
