<?php
class mig_20210201100228_edit_user_table
{
    public $dbHandle;
    
    public function __construct($dbHandle)
    {
        $this->dbHandle = $dbHandle;
        $this->up();
    }
    
    public function up()
    {
        // Rename user_psw to user_password
        $this->dbHandle->query('ALTER TABLE `users` CHANGE `user_psw` `user_password` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci AFTER `id_center`');

        // Move user_identifier to be after id_center
        $this->dbHandle->query('ALTER TABLE `users` CHANGE `user_identifier` `user_identifier` VARCHAR(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL AFTER `id_center`;');
    }
    
    public function down()
    {
        
    }
}
