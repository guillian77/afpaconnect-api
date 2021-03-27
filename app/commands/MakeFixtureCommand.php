<?php


namespace App\Command;

use App\Core\Database;

class MakeFixtureCommand
{
    /**
     * @var string
     */
    public static string $defaultName = 'make:fixture';

    /**
     * @var string
     */
    public static string $defaultDescription = 'Create a new fixture';

    public function __construct(Database $database)
    {
        echo "test";
        dump($database->fetchAll('SELECT * FROM users'));
    }
}
