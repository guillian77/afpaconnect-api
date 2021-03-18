<?php
namespace App\Core;

/**
 * Class App : Singleton
 *
 * @package App\Core
 *
 * @author Aufrère Guillian
 */
class App
{
    private static $_instance;

    private $configuration = null;

    public $root;

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new App();
        }

        return self::$_instance;
    }

    public function __construct()
    {
        $this->root =  dirname(dirname(__DIR__));
    }

    /**
     * Load configurations needed for all the app.
     *
     * @return array
     */
    public function configuration()
    {
        if (is_null($this->configuration)) {
            $instance = Configuration::getInstance();
            $this->configuration = $instance->get();
        }
        return $this->configuration;
    }

    /**
     * Check requirements needed to initialize the app.
     */
    public function requirements()
    {
        if (!file_exists('../modules/vendor/autoload.php') || !file_exists('../modules/core/Configuration.php'))
        {
            echo "<h1>Vous êtes nouveau içi ? 😅</h1>";
            echo "<p>Vous devez d'abord installer les dépendances nécessaires au fonctionnement de l'application.</p>";
            echo "<p>Exécutez cette commande dans la racine du répertoire du projet: <b>php artisan install</b></p>";
            die();
        }
    }

    /**
     * Initialize all is need to run the app.
     */
    public function initialize()
    {
        /** Check requirements */
        $this->requirements();

        /** Initialize configuration */
        require $this->root.'/modules/core/Configuration.php';
        $this->configuration();

        /** Display more error in development */
        if ($this->configuration['DEV']) {
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
        }

        $_SESSION['BASE_HREF'] = $this->configuration['BASE_HREF'];

        /** Auto loading */
        $this->autoload();
    }

    /**
     * Autoload all files needed on the app.
     *
     * vendor/autoload.php will include and create an instance of external classes.
     *
     * core/Autoload include internal app files.
     */
    public function autoload()
    {
        require $this->root.'/modules/vendor/autoload.php';
        require $this->root.'/modules/core/Autoload.php';
        new Autoload();
    }
}
