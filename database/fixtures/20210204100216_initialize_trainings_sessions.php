<?php
class fix_20210204100216_initialize_trainings_sessions
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
        $query = "INSERT INTO `formations` (`id`, `tag`, `name`, `degree`, `status`) VALUES (NULL, '2EZA58EAZ6', 'training_nmae', 'degree', '1')";
        $this->dbHandle->query($query);

        /**
         * Create session 
         */
        $query = "INSERT INTO `sessions` (`id`, `id_formation`, `tag`, `name`, `start_at`, `end_at`,  `status`) VALUES (NULL, '1', 'DWWM', 'Développeur web et web mobile', '2020-04-06 08:15:00', '2020-11-20 17:00:00',  '1')";
        $this->dbHandle->query($query);
    }
    
}
