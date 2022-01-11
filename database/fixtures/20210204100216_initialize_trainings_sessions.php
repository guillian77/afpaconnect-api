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
        $query = "INSERT INTO `formations` (`id`, `tag`, `name`, `degree`, `status`) VALUES (NULL, 'DWWM', 'Developpeur web', 'degree', '1')";
        $this->dbHandle->query($query);

        $query = "INSERT INTO `formations` (`id`, `tag`, `name`, `degree`, `status`) VALUES (NULL, 'CDA', 'Concepteur Développeur d\'Application', 'degree', '1')";
        $this->dbHandle->query($query);

        $query = "INSERT INTO `formations` (`id`, `tag`, `name`, `degree`, `status`) VALUES (NULL, 'J/P', 'Développeur Java Python', 'degree', '1')";
        $this->dbHandle->query($query);

        /**
         * Create session 
         */
        $query = "INSERT INTO `sessions` (`id`, `formation_id`, `name`, `n_offer`, `label_offer`, `start_at`, `end_at`,  `status`) VALUES (NULL, '1', 'Session-04-2020', 20150, 'OCC_DWWM_CR_2018_ELO', '2020-04-06 08:15:00', '2020-11-20 17:00:00',  '1')";
        $this->dbHandle->query($query);
    }
    
}
