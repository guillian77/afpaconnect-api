<?php
class fix_20210705010703_initialize_apps__roles
{
    public $dbHandle;
    
    public function __construct($dbHandle)
    {
        $this->dbHandle = $dbHandle;
        $this->exec();
    }
    
    public function exec()
    {
        /*
        * Create apps__roles
        */
       $query = "INSERT INTO `apps__roles` (`app_id`, `role_id`) 
        VALUES 
        (1, 1),
        (1, 2),
        (1, 3),
        (2, 1),
        (2, 2),
        (3, 1),
        (3, 2),
        (3, 3);";

        $this->dbHandle->query($query);
    }
    
}
