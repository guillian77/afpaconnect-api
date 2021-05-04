<?php

declare(strict_types=1);

namespace App\Command;

use App\Core\App;
use Symfony\Component\Console\Command\Command as Console;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class makeFixtureCommand extends Console
{
    public function __construct(string $name = null)
    {
        parent::__construct($name);
        $this->app = App::get();
    }

    protected function configure()
    {
        $this->setName('database:fixtures:create');
        $this->setDescription('Make fixtures creation great again');
        $this->addArgument('fixture_name', InputArgument::REQUIRED, 'Fixture name');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $app = App::get();

        $datetime = (new \DateTime())->format('Ymdhmi');
        $fixtureName = $datetime . "_" . $input->getArgument('fixture_name');
        $content  = "<?php\n";
        $content .= "class fix_" . $fixtureName . "\n";
        $content .= "{\n";
        $content .= "    public \$dbHandle;\n";
        $content .= "    \n";
        $content .= "    public function __construct(\$dbHandle)\n";
        $content .= "    {\n";
        $content .= "        \$this->dbHandle = \$dbHandle;\n";
        $content .= "        \$this->exec();\n";
        $content .= "    }\n";
        $content .= "    \n";
        $content .= "    public function exec()\n";
        $content .= "    {\n";
        $content .= "        \n";
        $content .= "    }\n";
        $content .= "    \n";
        $content .= "}\n";
        $content .= "";

        file_put_contents(DB . "fixtures/" . $fixtureName . ".php", $content);

        $output->writeln("Fixtures created successfully under " . DB . "fixtures/$fixtureName.php");

        return self::SUCCESS;
    }
}