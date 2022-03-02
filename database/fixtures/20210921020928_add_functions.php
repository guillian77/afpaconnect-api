<?php
class fix_20210921020928_add_functions
{
    public PDO $dbHandle;
    
    public function __construct($dbHandle)
    {
        $this->dbHandle = $dbHandle;
        $this->exec();
    }
    
    public function exec()
    {
        $this->dbHandle->query('INSERT INTO functions (tag, name) VALUES ("FUNCTION_INTERN", "Stagiaire")');
        $this->dbHandle->query('INSERT INTO functions (tag, name) VALUES ("FUNCTION_TEACHER", "Formateur")');
    }
}
