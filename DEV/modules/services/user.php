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
     * Get user by identifier.
     *
     * @param string $identifier
     * @return array
     */
    public function getUser(string $identifier)
    {
        $param = [
            'identifier' => $identifier
        ];

        return $this->oBdd->getSelectDatas("SELECT * FROM users WHERE user_identifier = '@identifier';", $param);
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

    /**
     * Insert a user inside database.
     *
     * @param object $user
     * @return \App\Core\PDOStatement|bool|false
     */
    public function insert(object $user)
    {
        $param = [
            "beneficiaire"=> $user->Beneficiaire,
            "fisrtname"=> $user->Nom_usuel,
            "name"=> $user->Prenom,
        ];

        $query = 'INSERT INTO users (`id_center`,`user_identifier`, `user_name` , `user_firstname`) VALUES (1, "@beneficiaire","@fisrtname","@name")';

        $this->oBdd->treatDatas($query,$param);

        $lastInsert = $this->oBdd->getLastInsertId();

        // Check if user has been added to databse before adding session.
        if ($lastInsert == 0) {
            return false;
        }

        $paramFormation = [
            "formation"=> $user->Formation,
            "id_user"=> $lastInsert
        ];
        $query = 'SELECT @session := id_session FROM sessions WHERE session_code = "@formation";';
        $query .= 'INSERT INTO `users__sessions`(`id_user`, `id_session`) VALUES (@id_user, @session)';

        return $this->oBdd->treatDatas($query,$paramFormation);
    }
}
