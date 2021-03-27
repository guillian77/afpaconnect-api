<?php


namespace App\Command;

class MigrateCommand
{
    /**
     * @var string
     */
    public static string $defaultName = 'database:migration:migrate';
    public static string $defaultDescription = 'Execute migrations';
}
