<?php

declare(strict_types=1);

namespace App\Command;

use App\Core\App;
use App\Core\Database;
use PDO;
use Symfony\Component\Console\Command\Command as Console;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DatabaseCreateCommand extends Console
{
    protected function configure()
    {
        $this->setName('database:create');
        $this->setDescription('Create and install the database.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $app = App::get();
        $container = $app->getContainer();

        $db = $container->get(Database::class);

        dump($db);

        $output->writeln(sprintf('Salut les gens'));
        return self::SUCCESS;
    }
}
