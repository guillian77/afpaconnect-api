<?php

declare(strict_types=1);

namespace App\Command;

use App\Core\App;
use App\Core\PdoDriver;
use PDO;
use Symfony\Component\Console\Command\Command as Console;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ServerCommand extends Console
{
    protected function configure()
    {
        $this->setName('serve');
        $this->setDescription('Start a PHP dev server.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        exec('php -S 127.0.0.1:8000 -t public/');

        return self::SUCCESS;
    }
}
