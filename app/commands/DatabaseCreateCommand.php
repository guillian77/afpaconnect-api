<?php

declare(strict_types=1);

namespace App\Command;

use App\Core\App;
use App\Core\Database\PdoDriver;
use DI\DependencyException;
use DI\NotFoundException;
use Exception;
use Symfony\Component\Console\Command\Command as Console;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;

class DatabaseCreateCommand extends Console
{
    protected function configure()
    {
        $this->setName('database:create');
        $this->setDescription('Install the database.');
        $this->addOption('scope', null, InputOption::VALUE_OPTIONAL, 'Apply Migrations and Fixtures too.');
        $this->setHelp(
            '--scope==partial will apply migrations | --scope=full apply migrations and fixtures.'
        );
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $app = App::get();

        $container = $app->getContainer();

        $db = $container->get(PdoDriver::class)->getConnection();

        $sql = file_get_contents(DB . 'base.sql');

        if (!$sql) { return self::FAILURE; }

        $output->writeln("Creating database from ".DB."base.sql.");

        $db->query($sql);

        $output->writeln('Database created successfully.');

        if (empty($input->getOption('scope'))) {
            return self::SUCCESS;
        }

        $scope = $input->getOption('scope');
        if ($scope == 'partial') {
            $this->callCommand('database:migrations:load', $output);
            $this->callCommand('database:fixtures:load', $output);
        } else if ($scope == 'full') {
            $this->callCommand('database:migrations:load', $output);
            $this->callCommand('database:fixtures:load', $output);
            $this->callCommand('database:triggers:load', $output);
        }

        return self::SUCCESS;
    }

    /**
     * Run an external command by command name.
     *
     * @param string $name
     * @param $mainOutput
     *
     * @throws Exception
     */
    private function callCommand(string $name, $mainOutput)
    {
        $app = $this->getApplication();

        $cmd = $app->find($name);

        $fakeInput = new ArrayInput([]);
        $fakeOutput = new BufferedOutput();

        $code = $cmd->run($fakeInput, $fakeOutput);

        if($code == 0) {
            $outputText = $fakeOutput->fetch();
            $mainOutput->writeln($outputText);
        }
    }
}
