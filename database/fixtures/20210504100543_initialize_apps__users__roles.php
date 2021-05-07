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

        /**
         * Create financials
         */
        $query = "INSERT INTO `financials` (`id`, `tag`, `name`, `public_name`) VALUES (NULL, 'PSMIL', 'Militaire', 'Militaire');";
        $this->dbHandle->query($query);

        /**
         * Create users
         */
        $users = [
            "admin",
            "lucas",
            "guillian",
            "younes",
            "damien",
            "benoit"
        ];

        foreach ($users as $user)
        {
            $password = password_hash('test', PASSWORD_ARGON2I );
            $email = $user . "@mail.fr";

            if ($user === "admin") {
                $identifier = "123456789";
            } else {
                $identifier = rand(100000000, 999999999);
            }
            $query = "INSERT INTO `users` 
            ( `id_center`,  `id_financial`, `identifier`, `lastName`, `firstName`, `mailPro`, `mailPerso`, `password`, `phone`, `address`, `complementAddress`, `zip`, `city`, `country`, `gender`, `status`, `created_at`, `updated_at`) 
            VALUES ('1', '1', :identifier, :lastname, :firstname, 'admin@admin.fr', :email, :password, '0102030405', '15 rue de ladmin', 'Bâtiment A', '34000', 'Montpellier', 'France', '1', '1', '2021-02-01', '2021-02-01 13:43:25')";
            $stmt = $this->dbHandle->prepare($query);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':identifier', $identifier);
            $stmt->bindParam(':lastname', $user);
            $stmt->bindParam(':firstname', $user);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
        }

        /**
         * Create roles
         */
        $query = "INSERT INTO `roles` (`id`, `tag`,`name`) 
                    VALUES 
                    (NULL, 100, 'SuperAdmin'),
                    (NULL, 10, 'Admin'),
                    (NULL, 1, 'User');";
        $this->dbHandle->query($query);

        /**
         * Create apps__users__roles
         */
        $query = "INSERT INTO `apps__users__roles` (`id_app`, `id_user`, `id_role`) 
                    VALUES (1, 1, 1),(2, 2, 2),(3, 3, 3),(1, 4, 3),(2, 5, 2),(3, 6, 1),(1, 2, 2),(2, 3, 3),(3, 4, 1);";
        $this->dbHandle->query($query);
    }
    
}
