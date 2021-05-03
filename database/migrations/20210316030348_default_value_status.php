<?php
class mig_20210316030348_default_value_status
{
    public $dbHandle;

    public function __construct($dbHandle)
    {
        $this->dbHandle = $dbHandle;
        $this->up();
    }

    public function up()
    {
        $this->dbHandle->query("ALTER TABLE `users` CHANGE `user_status` `user_status` TINYINT(1) NULL DEFAULT '1';");
    }

    public function down()
    {

    }
}
