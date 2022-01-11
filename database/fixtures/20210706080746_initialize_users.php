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
            "benoit",
            "unregistered"
        ];

        foreach ($users as $user)
        {
            $password = password_hash('test', PASSWORD_ARGON2I );
            $emailPro = "pro_".$user . "@mail.fr";
            $emailPerso = "perso_".$user . "@mail.fr";
            $activation_code = null;

            if ($user === "admin") {
                $identifier = "123456789";
                $activation_code = "6149c0068f0af";
            } else {
                $identifier = rand(100000000, 999999999);
            }
            $query = "INSERT INTO `users` 
            ( `center_id`,  `financial_id`, `identifier`, `lastName`, `firstName`, `mail1`, `mail2`, `password`, `phone`, `address`, `complementAddress`, `zip`, `city`, `country`, `gender`,`measure`,`convention`, `status`, `activation_code`, `created_at`, `updated_at`) 
            VALUES ('1', '1', :identifier, :lastname, :firstname, :emailPro, :emailPerso, :password, '0102030405', '15 rue de ladmin', 'Bâtiment A', '34000', 'Montpellier', 'France', '1','350-Cons Rég hors convention tripartite', '97014200270-PRF 2021 - QUALIF PRO - BC 19Q04351232_6 - PIC', '1', :activation_code, '2021-02-01', '2021-02-01 13:43:25')";
            $stmt = $this->dbHandle->prepare($query);
            
            $user == "unregistered_user" && $password = ""; 

            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':identifier', $identifier);
            $stmt->bindParam(':lastname', $user);
            $stmt->bindParam(':firstname', $user);
            $stmt->bindParam(':emailPro', $emailPro);
            $stmt->bindParam(':emailPerso', $emailPerso);
            $stmt->bindParam(':activation_code', $activation_code);
            $stmt->execute();
        }
    }
    
}
