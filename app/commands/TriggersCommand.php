<?php

declare(strict_types=1);

namespace App\Command;

use App\Core\App;
use App\Core\Database\EloquentDriver;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Illuminate\Database\Connection;
use PDO;
use Symfony\Component\Console\Command\Command as Console;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TriggersCommand extends Console
{
    private App $app;

    private Container $container;

    private PDO $pdo;

    private OutputInterface $output;

    private ?Connection $orm;

    /**
     * TriggersCommand constructor.
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
        $this->setName('database:triggers:load');
        $this->setDescription('Load triggers into database.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;

        $this->execTriggers($this->listTriggersFiles());

        return self::SUCCESS;
    }

    /**
     * Return an array of triggers files.
     *
     * @return array|null
     */
    private function listTriggersFiles(): ?array
    {
        $filelist = scandir(DB.'triggers');

        if (!$filelist) {
            return null;
        }

        // Remove linux path folder like . AND .. .
        array_splice($filelist, 0, 2);

        return $filelist;
    }

    /**
     * Execute triggers from an array of triggers files.
     * @param array $triggerFiles
     */
    private function execTriggers(array $triggerFiles)
    {
        $count = 0;
        foreach ($triggerFiles as $k => $triggerFile) {
            $this->output->writeln('<comment>'.$triggerFiles[$k].'</comment>');

            // Load an instance of current trigger.
            $triggerContent = file_get_contents(DB.'triggers/'.$triggerFile);

            if (!$triggerContent) {
                $this->output->writeln('<error>Failed to load content of '.DB.'trigger/'.$triggerFile.'</error>');
                continue;
            }

            $stmt = $this->pdo->query($triggerContent);

            $count++;
        }

        if ($count === 0) {
            $this->output->writeln( "<info>No triggers to execute.</info>");
        } else {
            $this->output->writeln("<info>$count trigger(s) has been inserted to database.</info>");
        }
    }
}
