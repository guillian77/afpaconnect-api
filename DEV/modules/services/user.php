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

        return $this->oBdd->getSelectDatas("SELECT * FROM users WHERE user_username = '@username';", $param);
    }

    /**
     * Get all users.
     *
     * @return array
     */
    public function getUsers()
    {
        return $this->oBdd->getSelectDatas('SELECT * FROM users');
    }

    public function insert(object $user)
    {
        $param = [
            "beneficiaire"=> $user->Beneficiaire,
            "fisrtname"=> $user->Nom_usuel,
            "name"=> $user->Prenom,
        ];

        $query = 'INSERT INTO users (`id_center`,`user_identifier`, `user_name` , `user_firstname`) VALUES (1, "@beneficiaire","@fisrtname","@name")';
        
        $this->oBdd->treatDatas($query,$param);

        $paramFormation = [
            "formation"=> $user->Formation,
            "id_user"=> $this->oBdd->getLastInsertId()
        ];
        $query = 'SELECT @session := id_session FROM sessions WHERE session_code = @formation;';
        $query .= 'INSERT INTO `users__sessions`(`id_user`, `id_session`) VALUES (@id_user, "@session")';

        $this->oBdd->treatDatas($query,$param);
    }
}
