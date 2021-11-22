<?php

declare(strict_types=1);

namespace App\Command;

use App\Core\App;
use App\Core\Database\EloquentDriver;
use App\Core\Database\PdoDriver;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Illuminate\Database\Connection;
use PDO;
use Symfony\Component\Console\Command\Command as Console;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MigrationsCommand extends Console
{
    private App $app;

    private Container $container;

    private PDO $pdo;

    private OutputInterface $output;

    private ?Connection $orm;

    /**
     * MigrationsCommand constructor.
     * @param string|null $name
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function __construct(string $name = null)
    {
        $this->app = App::get();

        $this->container = $this->app->getContainer();

        /** @var EloquentDriver $driver */
        $driver = $this->container->get(EloquentDriver::class);

        $this->orm = $driver->getConnection();

        $this->pdo = $this->orm->getPdo();

        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setName('database:migrations:load');
        $this->setDescription('Load migrations into database.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;

        $this->execMigrations($this->listMigrationsFiles());

        return self::SUCCESS;
    }

    /**
     * Return an array of migrations files.
     *
     * @return array|null
     */
    private function listMigrationsFiles(): ?array
    {
        $filelist = scandir(DB.'migrations');
        return $filelist === false ? [] :preg_grep("/[0-9]{14}_([a-zA-Z_.])*/", $filelist);
    }

    /**
     * Execute migrations from an array of migrations files.
     * @param array $migrationsFiles
     */
    private function execMigrations(array $migrationsFiles)
    {
        /**
         * Get last migration from DB.
         */

        $lastMigDateTime = $this->orm->table('migrations')->orderByDesc('datetime')->first();

        if (!$lastMigDateTime) { return; }

        /**
         * Filter on datetime.
         */
        $migDateTimes = preg_replace("/_([a-zA-Z_.])*/", "", $migrationsFiles);

        /**
         * Only search migration are not executed.
         */
        $migCount = 0;
        foreach ($migDateTimes as $k => $migDateTime)
        {
            if ($migDateTime > $lastMigDateTime->datetime)
            {
                $migCount++;

                $this->output->writeln('<comment>'.$migrationsFiles[$k].'</comment>');

                // Load an instance of current migration
                require DB.'migrations/'.$migrationsFiles[$k];
                $className = str_replace(".php", "", 'mig_'.$migrationsFiles[$k]);
                new $className($this->pdo);

                // Insert last migration executed
                $this->orm
                    ->table('migrations')
                    ->insert(['datetime' => $migDateTime]);
            }
        }

        if ($migCount === 0) {
            $this->output->writeln( "<info>Database is already up to date.</info>");
        } else {
            $this->output->writeln("<info>".$migCount . " migration(s) has been applied to database.</info>");
        }
    }
}
