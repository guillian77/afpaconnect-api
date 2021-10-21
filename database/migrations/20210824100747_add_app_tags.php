<?php
class mig_20210824100747_add_app_tags
{
    public PDO $dbHandle;
    
    public function __construct($dbHandle)
    {
        $this->dbHandle = $dbHandle;
        $this->exec();
    }
    
    public function exec()
    {
        $this->dbHandle->query('ALTER TABLE `apps` ADD `tag` VARCHAR(255) NOT NULL DEFAULT "" AFTER `name`');
    }
}
