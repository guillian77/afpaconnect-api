<?php


namespace App\Api;


class TestApi
{


    
    /***
     * Simulation - return an user with password
     * 
     * code 001 : password found
     * 
    */
    public function getUser()
    {

    $response = [];
    $response["message"] = "";
    $response["code"] = "001";
    $response["prenom"] = "Lucas";
    $response["nom"] = "Aufrere";
    $response["email"] = "lucas.aufrere@wanadoo.fr";

    Response::resp($response);
    
    }


    /***
     * Simulation - return an user without password
     * 
     * code 000 : no password found
     * 
    */
    public function getBlankUser()
    {

    $response = [];
    $response["message"] = "This user has never logged in one of the AFPA services : no password";
    $response["code"] = "000";
    $response["prenom"] = "Guillian";
    $response["nom"] = "Campillo";
    $response["email"] = "guillian.campillo@wanadoo.fr";

    Response::resp($response);
    
    }



}
