<?php

require 'DEV/modules/core/configuration.php';

class Artisan
{
    /**
     * @var array|mixed $args Arguments from command line.
     * Index[0] represent scriptname called.
     * Index[1] represent first argument.
     */
    public $args = [];

    /**
     * @var array $conf Configuration from configuration class.
     */
    public $conf = [];

    public $db;

    public function __construct()
    {
        $this->args = $_SERVER['argv'];

        // Stop Artisan if command does not exist.
        if (!method_exists($this, $this->args[1]) || !isset($this->args[1])) {
            $this->help();
            return;
        }

        // Get configuration
        $this->conf = Configuration::get();

        // Auto call method in this class with first argument passed.
        call_user_func([$this, $this->args[1]]);
    }

    public function __destruct()
    {
        unset($this->db);
    }

    /**
     * Command: Show available commands to user.
     */
    public function help()
    {
        echo "No command " . $this->args[1] . " find.\n";
        echo "---------------------------------\n";
        echo "COMMANDS AVAILABLE\n";
        echo "---------------------------------\n";
        echo "- help       Show help\n";
        echo "- migrate    Execute migrations\n";
    }

    /**
     * Command: Execute migrations.
     */
    public function migrate()
    {
        $this->dbConnect();

        $migrationsFiles = $this->listMigrations();

        $this->execMigrations($migrationsFiles);
    }

    /**
     * Command: Execute fixtures.
     */
    public function fixture()
    {
        $this->dbConnect();

        $fixtureFiles = $this->listFixtures();

        $this->execFixtures($fixtureFiles);
    }

    /**
     * Command: Make
     */
    public function make()
    {
        if (!isset($this->args[2]))
        {
            echo "- make database\n";
            echo "- make migration\n";
            echo "- make fixture\n";
            return;
        }

        switch ($this->args[2]) {
            case 'database':
                $this->makeDatabase();
                break;
            case 'migration':
                $this->makeMigration();
                break;
            case 'fixture':
                $this->makeFixture();
                break;
        }
    }

    /**
     * Connect Database and get connexion handle.
     */
    public function dbConnect()
    {
        // Check if handle does not already exist.
        if ( !isset($this->db) )
        {
            require_once "DEV/modules/core/database.php";
            $this->db = new Database($this->conf['db_hostname'], $this->conf['db_name'], $this->conf['db_username'], $this->conf['db_password']);
        }
    }

    /**
     * List migrations available inside migration directory.
     *
     * @return array
     */
    public function listMigrations()
    {
        $filelist = scandir(__DIR__ . "/" . $this->conf['PATH_MIGRATIONS']);
        return preg_grep("/[0-9]{14}_([a-zA-Z_.])*/", $filelist);
    }

    /**
     * Execute migrations from last migration find in database migrations table.
     *
     * @param $migrationsFiles
     */
    public function execMigrations($migrationsFiles)
    {
        /**
         * Get last migration from DB.
         */
        $lastMigDateTime = $this->db->_hDb->query('SELECT * FROM migrations ORDER BY migration_datetime DESC LIMIT 1');
        if (!$lastMigDateTime)
        {
            return;
        }
        $lastMigDateTime = $lastMigDateTime->fetch();
        $lastMigDateTime = $lastMigDateTime['migration_datetime'];


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
            if ($migDateTime > $lastMigDateTime)
            {
                $migCount++;

                // Load an instance of current migration
                require __DIR__ . "/" . $this->conf['PATH_MIGRATIONS'] . "/" . $migrationsFiles[$k];
                $className = str_replace(".php", "","mig_".$migrationsFiles[$k]);
                new $className($this->db->_hDb);

                // Insert last migration executed
                $this->db->_hDb->query("INSERT INTO migrations VALUES (null, $migDateTime)");
            }
        }

        if ($migCount === 0) {
            echo "Database is already up to date.";
        } else {
            echo $migCount . " migration(s) has been applied to database.";
        }
    }

    /**
     * List fixtures files available.
     *
     * @return array|false
     */
    public function listFixtures()
    {
        $filelist = scandir(__DIR__ . "/" . $this->conf['PATH_FIXTURES']);
        return preg_grep("/[0-9]{14}_([a-zA-Z_.])*/", $filelist);
    }

    /**
     * @param $fixturesFiles
     */
    public function execFixtures($fixturesFiles)
    {

        /**
         * Only search migration are not executed.
         */
        $fixCount = 0;
        foreach ($fixturesFiles as $k => $fixturesFile)
        {
            $fixCount++;

            // Load an instance of current migration
            require __DIR__ . "/" . $this->conf['PATH_FIXTURES'] . "/" . $fixturesFiles[$k];
            $className = str_replace(".php", "","fix_".$fixturesFiles[$k]);
            new $className($this->db->_hDb);
        }

        echo $fixCount . " fixture(s) has been applied to database.";
    }

    /**
     * Execute database creation script.
     * /!\ Database should already been created.
     */
    public function makeDatabase()
    {
        $sql = file_get_contents(__DIR__ . "/BDD/base.sql");
        $this->dbConnect();
        if($this->db->_hDb->query($sql)){
            echo "Database schema has been applied.\n";
            echo "Starting migrate\n";
            $this->migrate();

            if ( substr("--fix", 0, 5) )
            {
                echo "Inserting data fixtures.\n";
                $this->fixture();
            }
        }
    }

    /**
     * Create a new migration file.
     */
    public function makeMigration()
    {
        if (!isset($this->args[3]))
        {
            echo "You should specify a name to your migration.\n";
            echo "/!\ NO SPACES, use underscores";
            return;
        }

        $datetime = (new DateTime())->format('Ymdhmi');
        $migName = $datetime . "_" . $this->args[3];

        $content  = "<?php\n";
        $content .= "class mig_" . $migName . "\n";
        $content .= "{\n";
        $content .= "    public \$dbHandle;\n";
        $content .= "    \n";
        $content .= "    public function __construct(\$dbHandle)\n";
        $content .= "    {\n";
        $content .= "        \$this->dbHandle = \$dbHandle;\n";
        $content .= "        \$this->up();\n";
        $content .= "    }\n";
        $content .= "    \n";
        $content .= "    public function up()\n";
        $content .= "    {\n";
        $content .= "        \n";
        $content .= "    }\n";
        $content .= "    \n";
        $content .= "    public function down()\n";
        $content .= "    {\n";
        $content .= "        \n";
        $content .= "    }\n";
        $content .= "}\n";
        $content .= "";

        file_put_contents(__DIR__ . "/BDD/migrations/$migName.php", $content);

        echo "New migration has been created under " . __DIR__ . "/BDD/migrations/$migName.php";
    }

    public function makeFixture()
    {
        if (!isset($this->args[3]))
        {
            echo "You should specify a name to your fixture.\n";
            echo "/!\ NO SPACES, use underscores";
            return;
        }

        $datetime = (new DateTime())->format('Ymdhmi');
        $fixtureName = $datetime . "_" . $this->args[3];

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

        file_put_contents(__DIR__ . "/BDD/fixtures/$fixtureName.php", $content);

        echo "New fixture has been created under " . __DIR__ . "/BDD/fixtures/$fixtureName.php";
    }
}

new Artisan();