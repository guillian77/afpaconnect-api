<?php
class mig_20210921020919_add_app_desc_url
{
    public $dbHandle;
    
    public function __construct($dbHandle)
    {
        $this->dbHandle = $dbHandle;
        $this->exec();
    }
    
    public function exec()
    {
        $this->dbHandle->query("ALTER TABLE `apps` ADD `description` VARCHAR(255) NULL DEFAULT NULL AFTER `tag`, ADD `url` VARCHAR(255) NULL DEFAULT NULL AFTER `description`");
    }
    
}
