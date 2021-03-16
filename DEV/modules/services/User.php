<?php
namespace App\Service;

use App\Core\Service;
use App\Utility\Response;
use PDOStatement;

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
    public function getUser(string $identifier): array
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
    public function getUsers(): array
    {
        return $this->oBdd->getSelectDatas('SELECT * FROM users');
    }

    /**
     * Insert a user inside database.
     *
     * @param object $user
     * @return PDOStatement|bool|false
     */
    public function insert($user)
    {
        if(!isset($user->Beneficiaire) || !isset($user->Nom_usuel) || !isset($user->Prenom) || !isset($this->VARS_HTML['center']))
        {
            Response::resp("Erreur: Impossible d'ajouter les utilisateurs dans la base de données. Arrêt de l'import, veuillez vérifier le format du tableau XLSX", 400, true);
        }

        $param = [
            "center" => $this->VARS_HTML['center'],
            "beneficiaire"=> $user->Beneficiaire,
            "firstname"=> $user->Nom_usuel,
            "name"=> $user->Prenom,
        ];

        $query = 'INSERT INTO users (`id_center`,`user_identifier`, `user_name` , `user_firstname`) VALUES (@center, "@beneficiaire","@firstname","@name")';

        $this->oBdd->treatDatas($query,$param);

        $lastInsert = $this->oBdd->getLastInsertId();

        // Check if user has been added to database before adding session.
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
