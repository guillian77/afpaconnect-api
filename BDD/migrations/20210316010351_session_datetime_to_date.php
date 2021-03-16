<?php
class mig_20210316010351_session_datetime_to_date
{
    public $dbHandle;
    
    public function __construct($dbHandle)
    {
        $this->dbHandle = $dbHandle;
        $this->up();
    }
    
    public function up()
    {
        $this->dbHandle->query("ALTER TABLE `sessions` CHANGE `session_start_at` `session_start_at` DATE NOT NULL, CHANGE `session_end_at` `session_end_at` DATE NOT NULL;");
    }
    
    public function down()
    {
        
    }
}
