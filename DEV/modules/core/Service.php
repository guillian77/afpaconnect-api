<?php
namespace App\Core;

class Service
{
    /** @var Request $request An instance of Request class. */
    protected $request;

    /** @var array $configuration */
    protected $configuration;

    /** @var Database $db The instance of Database class. */
    protected $db;

    public function __construct()
    {
        $this->configuration= (App::getInstance())->configuration();
        $this->db = Database::getInstance();
        $this->request = Request::getInstance();
    }

    public function __destruct()
    {
        unset($this->db);
    }
}
