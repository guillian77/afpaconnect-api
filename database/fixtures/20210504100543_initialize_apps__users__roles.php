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
        $query = "INSERT INTO `apps` (`id_application`, `app_name`, `app_status`, `app_hostname`, `app_bddName`) 
                    VALUES 
                    (NULL, 'Afpaconnect', 1, 'hostname.afpaconnect', 'afpaconnect'),
                    (NULL, 'Afpacar', 1, 'hostname.afpacar', 'afpacar'),
                    (NULL, 'Afpanier', 1, 'hostname.afpanier', 'afpanier');";
        $this->dbHandle->query($query);

        /**
         * Create centers
         */
        $query = "INSERT INTO `centers` (`id_center`, `center_name`, `center_address`, `center_complementAddress`, `center_zipCode`, `center_city`, `center_schedule`, `center_contactMail`, `center_withdrawalPlace`, `center_withdrawalSchedule`, `center_urlGoogleMap`) VALUES (NULL, 'AFPA St. Jean de Vedas', 'St. Jean de Vedas', 'St. Jean de Vedas', '34011', 'St. Jean de Vedas', 'N/R', 'afpa@afpa.fr', 'N/R', 'N/R', 'N/R');";
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
            $query = "INSERT INTO `users` ";
            $query .= "( `id_center`, `user_identifier`, `user_name`, `user_firstName`, `user_mailPro`, `user_mailPerso`, `user_password`, `user_phone`, `user_address`, `user_complementAddress`, `user_zipCode`, `user_city`, `user_country`, `user_gender`, `user_status`, `user_created_at`, `user_updated_at`) ";
            $query .= "VALUES ('1', :identifier, :lastname, :firstname, 'admin@admin.fr', :email, :password, '0102030405', '15 rue de l\'admin', 'Bâtiment A', '34000', 'Montpellier', 'France', '1', '1', '2021-02-01', '2021-02-01 13:43:25')";
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
        $query = "INSERT INTO `roles` (`id_role`, `role_name`) 
                    VALUES 
                    (NULL, 'SuperAdmin'),
                    (NULL, 'Admin'),
                    (NULL, 'User');";
        $this->dbHandle->query($query);

        /**
         * Create apps__users__roles
         */
        $query = "INSERT INTO `apps__users__roles` (`id_application`, `id_user`, `id_role`) 
                    VALUES (1, 1, 1),(2, 2, 2),(3, 3, 3),(1, 4, 3),(2, 5, 2),(3, 6, 1),(1, 2, 2),(2, 3, 3),(3, 4, 1);";
        $this->dbHandle->query($query);
    }
    
}
