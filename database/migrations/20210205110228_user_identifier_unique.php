<?php
class mig_20210205110228_user_identifier_unique
{
    public $dbHandle;

    public function __construct($dbHandle)
    {
        $this->dbHandle = $dbHandle;
        $this->up();
    }

    public function up()
    {
        // Identifier should be unique !
        $this->dbHandle->query('ALTER TABLE `users` ADD UNIQUE(`user_identifier`)');
    }

    public function down()
    {

    }
}
