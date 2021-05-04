<?php

declare(strict_types=1);

namespace App\Command;

use App\Core\App;
use App\Core\Database;
use Symfony\Component\Console\Command\Command as Console;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FixturesCommand extends Console
{

    private App $app;
    private \DI\Container $container;

    public function __construct(string $name = null)
    {
        parent::__construct($name);
        $this->app = App::get();
        $this->container = $this->app->getContainer();
    }

    protected function configure()
    {
        $this->setName('database:fixtures:load');
        $this->setDescription('Load Fixtures');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $listFixtures = scandir(DB . "fixtures/");
        $listFixtures = preg_grep("/[0-9]{14}_([a-zA-Z_.])*/", $listFixtures);

        if (empty($listFixtures)) { return self::FAILURE; }

        $db = $this->container->get(Database::class)->getPdo();

        foreach ($listFixtures as $k => $fixtureFile)
        {
            // Load an instance of current migration
            require DB."fixtures/" . $listFixtures[$k];
            $className = str_replace(".php", "","fix_".$listFixtures[$k]);
            new $className($db);
        }

        $output->writeln(count($listFixtures) . ' Fixture(s) has been applied to database.');

        return self::SUCCESS;
    }
}
