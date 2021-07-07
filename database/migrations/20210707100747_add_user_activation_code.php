<?php
class mig_20210707100747_add_user_activation_code
{
    public $dbHandle;
    
    public function __construct($dbHandle)
    {
        $this->dbHandle = $dbHandle;
        $this->exec();
    }
    
    public function exec()
    {
        $this->dbHandle->query('ALTER TABLE `users` ADD `activation_code` VARCHAR(255) NULL AFTER `status`');
    }
}
