<?php
class mig_20211022111006_add_role_level
{
    public $dbHandle;
    
    public function __construct($dbHandle)
    {
        $this->dbHandle = $dbHandle;
        $this->exec();
    }
    
    public function exec()
    {
        $this->dbHandle->query('ALTER TABLE `roles` ADD `level` INT(11) NOT NULL AFTER `name`, ADD UNIQUE (`level`)');
    }
    
}
