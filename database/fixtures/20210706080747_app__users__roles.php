<?php
class fix_20210706080747_app__users__roles
{
    public $dbHandle;
    
    public function __construct($dbHandle)
    {
        $this->dbHandle = $dbHandle;
        $this->exec();
    }
    
    public function exec()
    {
        /**
         * Create apps__users__roles
         */
        $query = "INSERT INTO `apps__users__roles` (`app_id`, `user_id`, `role_id`) 
                    VALUES (1, 1, 1),(1, 1, 2),(1, 1, 3),(2, 2, 2),(3, 3, 3),(1, 4, 3),(2, 5, 2),(3, 6, 1),(1, 2, 2),(2, 3, 3),(3, 4, 1);";
        $this->dbHandle->query($query);
    }
    
}
