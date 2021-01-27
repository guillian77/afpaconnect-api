<?php

class Database
{
    /**
     * @var PDOStatement
     */
    public $handle;

    public function __construct()
    {
        $config = Configuration::database();
        $this->handle = new PDO("mysql:host=" . $config['hostname'] . ";dbname=" . $config['dbname'], $config['username'], $config['password']);
    }

    public function __destruct()
    {
        unset($this->handle);
    }
}