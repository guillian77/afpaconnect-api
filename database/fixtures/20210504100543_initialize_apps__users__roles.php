<?php
class fix_20210504100543_initialize_apps__users__roles
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
         * Create apps
         */
        $query = "INSERT INTO `apps` (`id`, `name`, `status`) 
                    VALUES 
                    (NULL, 'Afpaconnect', 1),
                    (NULL, 'Afpacar', 1),
                    (NULL, 'Afpanier', 1);";
        $this->dbHandle->query($query);

        /**
         * Create centers
         */
        $query = "INSERT INTO `centers` (`id`, `name`, `address`, `complementAddress`, `zip`, `city`, `schedule`, `mail`, `withdrawalPlace`, `withdrawalSchedule`, `urlGoogleMap`) VALUES (NULL, 'AFPA St. Jean de Vedas', 'St. Jean de Vedas', 'St. Jean de Vedas', '34011', 'St. Jean de Vedas', 'N/R', 'afpa@afpa.fr', 'N/R', 'N/R', 'N/R');";
        $this->dbHandle->query($query);

        $query = "INSERT INTO `centers` (`id`, `name`, `address`, `complementAddress`, `zip`, `city`, `schedule`, `mail`, `withdrawalPlace`, `withdrawalSchedule`, `urlGoogleMap`) VALUES (NULL, 'AFPA Toulouse Balma', '73 rue Saint-Jean', '', '31130', 'Balma', 'N/R', 'afpa@afpa.fr', 'N/R', 'N/R', 'N/R');";
        $this->dbHandle->query($query);


        /**
         * Create roles
         */
        $query = "INSERT INTO `roles` (`id`, `tag`,`name`,`level`) 
                    VALUES 
                    (NULL, 'ROLE_USER', 'Utilisateur', 1000),
                    (NULL, 'ROLE_ADMIN', 'Administrateur', 200),
                    (NULL, 'ROLE_SUPER_ADMIN', 'Super Admin', 100)";
        $this->dbHandle->query($query);
    }
    
}
