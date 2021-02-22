<?php
class fix_20210204100216_create_session
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
         * Create training first
         */
        $query = "INSERT INTO `trainings` (`id_training`, `training_name`, `training_degree`, `training_code`, `training_status`) VALUES (NULL, 'training', 'degree', '2EZA58EAZ6', '1')";
        $this->dbHandle->query($query);

        /**
         * Create session 
         */
        $query = "INSERT INTO `sessions` (`id_session`, `id_training`, `session_code`, `session_start_at`, `session_end_at`, `session_entitled`, `session_status`) VALUES (NULL, '1', 'DWWM', '2020-04-06 08:15:00', '2020-11-20 17:00:00', 'Développeur web et web mobile', '1')";
        $this->dbHandle->query($query);
    }
    
}
