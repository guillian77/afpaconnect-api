<?php

require 'DEV/web/configuration.php';

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
        if (!method_exists($this, $this->args[1])) {
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
     * Show available commands to user.
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
     * Execute migrations.
     */
    public function migrate()
    {
        $this->dbConnect();

        $migrationsFiles = $this->listMigrations();

        $this->execMigrations($migrationsFiles);
    }

    /**
     * Connect Database and get connexion handle.
     */
    public function dbConnect()
    {
        // Check if handle does not already exist.
        if ( !isset($this->db) )
        {
            require_once "DEV/modules/database.php";
            $this->db = new Database($this->conf['db']['hostname'], $this->conf['db']['dbname'], $this->conf['db']['username'], $this->conf['db']['password']);
        }
    }

    /**
     * List migrations available inside migration directory.
     *
     * @return array
     */
    public function listMigrations()
    {
        $filelist = scandir(__DIR__ . "/" . $this->conf['path']['MIGRATIONS']);
        return preg_grep("/[0-9]{14}_([a-zA-Z_.])*/", $filelist);
    }

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
                require __DIR__ . "/" . $this->conf['path']['MIGRATIONS'] . "/" . $migrationsFiles[$k];
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

    public function make()
    {
        if (!isset($this->args[2]))
        {
            echo "- make database\n";
            echo "- make migration\n";
            return;
        }

        switch ($this->args[2]) {
            case 'database':
                $this->makeDatabase();
                break;
            case 'migration':
                $this->makeMigration();
                break;
        }
    }

    public function makeDatabase()
    {
        $sql = file_get_contents(__DIR__ . "/BDD/base.sql");
        $this->dbConnect();
        $this->db->_hDb->query($sql);
    }

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
}

new Artisan();