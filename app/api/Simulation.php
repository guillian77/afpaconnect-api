<?php


namespace App\Api;


use App\Utility\Response;

class Simulation
{
    private Response $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * Simulation - return a user with password
     *
     * code 001 : password found
     */
    public function getUser()
    {
        $user = [
            'firstname' => 'Guillian',
            'lastname' => 'Campillo',
            'email' => 'guillian.campillo@wanadoo.fr',
        ];

        $this->response
            ->setStatusCode("001")
            ->setStatusMessage("User is registered.")
            ->setBodyContent($user)
            ->send();
    }


    /***
     * Simulation - return an user without password
     * 
     * code 000 : no password found
     * 
    */
    public function getBlankUser()
    {
        $user = [
            'firstname' => 'Guillian',
            'lastname' => 'Campillo',
            'email' => 'guillian.campillo@wanadoo.fr',
        ];

        $this->response
            ->setStatusCode("000")
            ->setStatusMessage("This user has never logged in one of the AFPA services : no password")
            ->setBodyContent($user)
            ->send();
    }
}
