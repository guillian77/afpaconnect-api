<?php
namespace App\Core;

class Autoload
{
    public $classname;
    public $namespace;

    private $_config;

    /**
     * Autoload constructor.
     */
    public function __construct($_config)
    {
        $this->_config = $_config;

        spl_autoload_register(function($className) {
            $expload = explode("\\", $className);
            $this->classname = $expload[count($expload)-1];
            $this->namespace = trim( str_replace($this->classname, "", $className), "\\" );

            $this->load( $this->associate() );
        });
    }

    /**
     * Associate Namespaces with physical directory location.
     *
     * @return mixed|string
     */
    public function associate()
    {
        $dir = "";

        switch ($this->namespace) {
            case 'App\Service':
                $dir = $this->_config['PATH_CLASS'] . 'services/';
                break;
            case 'App\Core':
                $dir = $this->_config['PATH_CLASS'] . 'core/';
                break;
            case 'App\Controller':
                $dir = $this->_config['PATH_CLASS'];
                break;
            case 'App\Api':
                $dir = $this->_config['PATH_CLASS'] . 'api/';
                break;
            case 'App\Utility':
                $dir = $this->_config['PATH_CLASS'] . 'utilities/';
                break;
        }

        return $dir;
    }

    public function load($dir)
    {
        $path = $dir . $this->classname . ".php";

        if ( file_exists($path) ) {
            require $path;
        } else {
            http_response_code(404);
        }
    }
}