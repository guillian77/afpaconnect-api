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
         * Create center first
         */
        $query = "INSERT INTO `centers` (`id_center`, `center_name`, `center_address`, `center_complementAddress`, `center_zipCode`, `center_city`, `center_schedule`, `center_contactMail`, `center_withdrawalPlace`, `center_withdrawalSchedule`, `center_urlGoogleMap`) VALUES (NULL, 'AFPA St. Jean de Védas', 'St. Jean de Védas', 'St. Jean de Védas', '34011', 'St. Jean de Védas', 'N/R', 'afpa@afpa.fr', 'N/R', 'N/R', 'N/R');";
        $this->dbHandle->query($query);

        /**
         * Create admin user: admin/admin
         */
        $query = "INSERT INTO `users` (`id_user`, `id_center`, `user_username`, `user_password`, `user_identifier`, `user_name`, `user_firstName`, `user_mailPro`, `user_mailPerso`, `user_phone`, `user_address`, `user_complementAddress`, `user_zipCode`, `user_city`, `user_country`, `user_gender`, `user_status`, `user_created_at`, `user_updated_at`) VALUES (NULL, '1', 'admin', :password, '12345678', 'admin', 'admin', 'admin@admin.fr', 'admin@admin.fr', '0102030405', '15 rue de l\'admin', 'Bâtiment A', '34000', 'Montpellier', 'France', '1', '1', '2021-02-01', '2021-02-01 13:43:25')";
        $stmt = $this->dbHandle->prepare($query);
        $hash = password_hash('admin', PASSWORD_ARGON2I );
        $stmt->bindParam(':password', $hash);
        $stmt->execute();
    }
    
}
