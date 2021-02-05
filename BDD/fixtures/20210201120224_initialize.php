<?php
class fix_20210201120224_initialize
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
         * ----------------------------------------------------
         * CREATE CENTER
         * ----------------------------------------------------
         */
        $query = "INSERT INTO `centers` (`id_center`, `center_name`, `center_address`, `center_complementAddress`, `center_zipCode`, `center_city`, `center_schedule`, `center_contactMail`, `center_withdrawalPlace`, `center_withdrawalSchedule`, `center_urlGoogleMap`) VALUES (NULL, 'AFPA St. Jean de Védas', 'St. Jean de Védas', 'St. Jean de Védas', '34011', 'St. Jean de Védas', 'N/R', 'afpa@afpa.fr', 'N/R', 'N/R', 'N/R');";
        $this->dbHandle->query($query);

        /**
         * ----------------------------------------------------
         * CREATE USERS
         * ----------------------------------------------------
         */
        $users = [
            "admin",
            "lucas",
            "guillian",
            "younes",
            "damien",
            "benôit"
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

            $query  = "INSERT INTO `users` ";
            $query .= "(`id_user`, `id_center`, `user_password`, `user_identifier`, `user_name`, `user_firstName`, `user_mailPro`, `user_mailPerso`, `user_phone`, `user_address`, `user_complementAddress`, `user_zipCode`, `user_city`, `user_country`, `user_gender`, `user_status`, `user_created_at`, `user_updated_at`) ";
            $query .= "VALUES ";
            $query .= "(NULL, '1', :password, :identifier, :lastname, :firstname, 'admin@admin.fr', :email, '0102030405', '15 rue de l\'admin', 'Bâtiment A', '34000', 'Montpellier', 'France', '1', '1', '2021-02-01', '2021-02-01 13:43:25')";

            $stmt = $this->dbHandle->prepare($query);

            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':identifier', $identifier);
            $stmt->bindParam(':lastname', $user);
            $stmt->bindParam(':firstname', $user);
            $stmt->bindParam(':email', $email);

            $stmt->execute();
        }
    }
    
}
