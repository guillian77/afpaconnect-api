<?php
class mig_20210201120255_move_up_center_foreign_key
{
    public $dbHandle;

    public function __construct($dbHandle)
    {
        $this->dbHandle = $dbHandle;
        $this->up();
    }

    public function up()
    {
        $this->dbHandle->query('ALTER TABLE `users` CHANGE `id_center` `id_center` INT(11) NOT NULL AFTER `id_user`');
    }

    public function down()
    {

    }
}
