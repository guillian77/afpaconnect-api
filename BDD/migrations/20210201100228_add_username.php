<?php
class mig_20210201100228_add_username
{
    public $dbHandle;
    
    public function __construct($dbHandle)
    {
        $this->dbHandle = $dbHandle;
        $this->up();
    }
    
    public function up()
    {
        $this->dbHandle->query('ALTER TABLE `users` ADD `user_username` VARCHAR(255) NOT NULL AFTER `id_user`');
        $this->dbHandle->query('ALTER TABLE `users` CHANGE `user_psw` `user_password` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL AFTER `user_username`');
    }
    
    public function down()
    {
        
    }
}
