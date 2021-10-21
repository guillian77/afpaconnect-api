<?php
class mig_20211021031033_add_user_temp_password
{
    public $dbHandle;
    
    public function __construct($dbHandle)
    {
        $this->dbHandle = $dbHandle;
        $this->exec();
    }
    
    public function exec()
    {
        $this->dbHandle->query('ALTER TABLE `users` ADD `password_temp` VARCHAR(255) NULL DEFAULT NULL AFTER `activation_code`');
    }
    
}
