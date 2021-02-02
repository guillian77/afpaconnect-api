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
     * @param int $limit Max users to get
     */
    public function getUsers(int $limit = null)
    {

    }
}
