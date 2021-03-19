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
     * Get user by id.
     *
     * @param string $id
     * @return array
     */
    public function getUserById(string $id): array
    {
        $param = [
            'id' => $id
        ];
        
        return $this->oBdd->getSelectDatas("SELECT * FROM users WHERE id_user = '@id';", $param);
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
        if(!isset($user->beneficiaire) || !isset($user->nom_usuel) || !isset($user->prenom) || !isset($this->VARS_HTML['center']))
        {
            Response::resp("Erreur: Impossible d'ajouter les utilisateurs dans la base de données. Arrêt de l'import, veuillez vérifier le format du tableau XLSX", 400, true);
        }

        $param = [
            "center" => $this->VARS_HTML['center'],
            "beneficiaire"=> $user->beneficiaire,
            "firstname"=> $user->nom_usuel,
            "name"=> $user->prenom,
        ];

        $query = 'INSERT INTO users (`id_center`,`user_identifier`, `user_name` , `user_firstname`) VALUES (@center, "@beneficiaire","@firstname","@name")';

        $this->oBdd->treatDatas($query,$param);

        $lastInsert = $this->oBdd->getLastInsertId();

        // Check if user has been added to database before adding session.
        if ($lastInsert == 0) {
            return false;
        }

        $paramFormation = [
            "date_debut" => $user->date_de_debut,
            "date_fin" => $user->date_de_fin,
            "formation"=> $user->formation,
            "id_user"=> $lastInsert
        ];
        $query = 'SELECT @session := id_session FROM sessions WHERE session_code = "@formation" AND session_start_at = "@date_debut" AND session_end_at = "@date_fin";';
        $query .= 'INSERT INTO `users__sessions`(`id_user`, `id_session`) VALUES (@id_user, @session)';

        return $this->oBdd->treatDatas($query,$paramFormation);
    }


    /**
     * TODO : dynamic update of role by application
     */
    public function update($user, $role) {
       
          if(!isset($user->id) )
        {
            Response::resp("Erreur: Impossible d'ajouter les utilisateurs dans la base de données. Arrêt de l'import, veuillez vérifier le format du tableau XLSX", 400, true);
        }

        $param = [
            "beneficiary"=> $user->beneficiary,
            "lastname"=> $user->lastname,
            "firstname"=> $user->firstname,
            "email"=> $user->email,
            "phone"=> $user->phone,
            "id" => $user->id
        ];

    
        $query = "UPDATE `users` SET `user_identifier`='@beneficiary',`user_name`='@lastname',`user_firstName`='@firstname',`user_mailPerso`='@email',`user_phone`='@phone' WHERE `id_user`=@id;";
        

        // TODO : fix query (returns false)
        foreach ($role as $a => $r) {
            if($r != 0) {
                $param["app"] = substr($a, -1);
                $param["role"] = $r;
                
               
                $update_role_query = "UPDATE `apps__users__roles` SET `id_role`= @role WHERE `user_id` = @id AND application_id = @app;";
                
               if(!$this->oBdd->treatDatas($update_role_query,$param)){
                $insert_role_query = "INSERT INTO `apps__users__roles`(`id_application`, `id_user`, `id_role`) VALUES (@app, @id, @role)";
                var_dump($this->oBdd->treatDatas($insert_role_query, $param));
                };
            }
           
        }
        
        return $this->oBdd->treatDatas($query,$param);
    }

   
}
