<?php
class fix_20210706080746_initialize_users
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
            ( `center_id`,  `financial_id`, `identifier`, `lastName`, `firstName`, `mail1`, `mail2`, `password`, `phone`, `address`, `complementAddress`, `zip`, `city`, `country`, `gender`,`measure`,`convention`, `status`, `created_at`, `updated_at`) 
            VALUES ('1', '1', :identifier, :lastname, :firstname, 'admin@admin.fr', :email, :password, '0102030405', '15 rue de ladmin', 'Bâtiment A', '34000', 'Montpellier', 'France', '1','350-Cons Rég hors convention tripartite', '97014200270-PRF 2021 - QUALIF PRO - BC 19Q04351232_6 - PIC', '1', '2021-02-01', '2021-02-01 13:43:25')";
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
