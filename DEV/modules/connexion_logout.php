<?php
require_once "service.php";
/**
 * Class connexion_logout | fichier connexion_logout.php
 *
 * Description de la classe à renseigner.
 *
 * List of classes needed for this class :
 *
 * require_once "service.php";
 *
 * @package AfpaCar Project
 * @subpackage service
 * @author @Afpa Lab Team - Prenom Nom stagiaire
 * @copyright  1920-2080 The Afpa Lab Team Group Corporation World Company
 * @version v1.0
 */

Class Connexion_logout	{
	
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
		$_SESSION= [];
		session_destroy();
				
		$objet_service = new Service();
        // call method from service
		
        // Retrieve parameters to access in html page
		$this->resultat = $objet_service->resultat;
		$this->VARS_HTML = $objet_service->VARS_HTML;
    }
	
}

?>

