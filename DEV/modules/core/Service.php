<?php
namespace App\Core;

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
