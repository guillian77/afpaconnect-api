<?php

declare(strict_types=1);

namespace App\Command;

use App\Core\App;
use Symfony\Component\Console\Command\Command as Console;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class makeMigrationCommand extends Console
{
    public function __construct(string $name = null)
    {
        parent::__construct($name);
        $this->app = App::get();
    }

    protected function configure()
    {
        $this->setName('database:migrations:create');
        $this->setDescription('Make migrations creation great again');
        $this->addArgument('migration_name', InputArgument::REQUIRED, 'Migration name');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $datetime = (new \DateTime())->format('Ymdhmi');
        $migrationName = $datetime . "_" . $input->getArgument('migration_name');
        $content  = "<?php\n";
        $content .= "class mig_" . $migrationName . "\n";
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

        file_put_contents(DB . "migrations/" . $migrationName . ".php", $content);

        $output->writeln("Migrations created successfully under " . DB . "migrations/$migrationName.php");

        return self::SUCCESS;
    }
}