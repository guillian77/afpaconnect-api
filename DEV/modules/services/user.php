<?php
namespace App\Service;

use App\Core\Service;

class User extends Service
{
    /**
     * @var array $VARS_HTML Secured POST, GET, SESSION.
     */
    public $VARS_HTML;

    public  function __construct()
    {
        parent::__construct();
    }

    /**
     * Get user by username.
     *
     * @param string $username
     * @return array
     */
    public function getUser(string $username)
    {
        $param = [
            'username' => $username
        ];

        return $this->oBdd->getSelectDatas("SELECT * FROM users WHERE user_username = '@username'", $param);
    }

    /**
     * Get all users.
     *
     * @return array
     */
    public function getUsers()
    {
        return $this->oBdd->getSelectDatas("SELECT * FROM users GROUP BY id_user");
    }

    /**
     * Get all users.
     *
     * @return array
     */
    public function getUsersSecured()
    {
        return $this->oBdd->getSelectDatas("SELECT id_user, id_center, user_username, user_identifier, user_name, user_firstName, user_mailPro, user_mailPerso, user_phone, user_address, user_complementAddress, user_zipCode, user_city, user_country, user_gender, user_status, user_created_at, user_updated_at FROM users GROUP BY id_user");
    }
}
