<?php

/**
 * Class mig_20210129153833_update_users
 *
 * THIS IS AN EXEMPLE OF MIGRATION.
 *
 * /!\ PLEASE REPLACE DATETIME BY YOURS.
 */
class mig_20210129153833_update_users
{
    public $dbHandle;

    public function __construct($dbHandle)
    {
        $this->dbHandle = $dbHandle;
        $this->up();
    }

    public function up()
    {
        $this
            ->dbHandle
            ->query('SELECT * FROM migrations')
            ->fetch();
    }

    public function down()
    {

    }
}