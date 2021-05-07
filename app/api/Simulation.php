<?php


namespace App\Api;


use App\Core\Request;
use App\Utility\Response;


class Simulation
{

    private Response $response;
    private Request $request;
    private string $userId;
    private string $password;


    public function __construct(Response $response, Request $request)
    {
        $this->response = $response;
        $this->request = $request;

        $this->userId =  $this->request->query()->get('userId');
        $this->password =  $this->request->query()->get('password');
    }

    /**
     * CODES RESPONSE 
     * 
     * 001 : LogIn / User succesfully logged
     * 002 : LogIn / User without password
     * 003 : LogIn / Wrong Password
     * 004 : LogIn / User not found
     * 005 : LogIn / Missing information / Password or User empty
     * 006 : Pass Register / Successfully registered
     * 007 : Pass Register / Wrong Password Format
     * 008 : Pass Register / User not found
     * 
     * 
     * 
     */

     
    /**
     * SIMULATION - LogIn 
     * Specificity => lambda, stagiaire, CDA, PSMIL 
     * 
     * Response code 001 : user found and password is valid.
     * Response code 005 : missing information.
     * 
     */
    public function success()
    {
        if($this->checkPostData()) {
            $user = [
                'id' => 1,
                'identifier' => '01020304',
                'lastName' => 'Aufrere',
                'firstName' => 'Lucas',
                'mailPro' => 'lucas.aufrere@afpaconnect.fr',
                'mailPerso' => 'lucas.aufrere@wanadoo.fr',
                'phone' => '0606060606',
                'adress' => '2 rue de la rue',
                'complementAdress' => 'Batiment B',
                'zipCode' => '34000',
                'city' => 'Montpellier',
                'country' => 'France',
                'gender' => '0',
                'status' => '1',
                'created_at' => 20210430 ,
                'updated_at' => null,
                'role' => [
                    'id' => 1,
                    'tag' => 'ROLE_USER',
                    'name' => 'Rôle utilisateur'
                ],
                'function' => [
                    'id' => 1,
                    'tag' => 'STAGIAIRE',
                    'name' => 'stagiaire',
                    'start_at' => 20210505,
                    'end_at' => 20211212
                ], 
                'session' => [
                    [
                        'id' => 1,
                        'tag' => 'DWWM025',
                        'name' => 'Dev Web et Web Mobile 05/2021-12/2021',
                        'start_at' => 20210505,
                        'end_at' => 20211212,
                        'status'=> 1,
                        'formation' => [
                          'id' => 1,
                          'tag' => 'DWWM',
                          'name' => 'Développeur web et web mobile',
                          'degree' => 'degree',
                          'status' => 1
                        ]
                    ],
                
                ],
                'center' => [
                    'id'=> 1,
                    'name' => 'Saint-Jean de Védas',
                    'adress' => 'rue Jean Mermoz',
                    'complementAdress' => 'zone d\'activité' ,
                    'zipCode' => '34430',
                    'city'=> 'Saint-Jean de Védas',
                    'schedule'=> 'schedule',
                    'contactMail'=> 'contact@afpa.com',
                    'withdrawalPlace'=> 'withdrawalPlace',
                    'withdrawalSchedule'=> 'withdrawalSchedule',
                    'urlGoogleMap'=> 'https://www.google.com/maps/place/AFPA/@43.5645741,3.8428852,17z/data=!3m1!4b1!4m5!3m4!1s0x12b6b1e78790b019:0x5fe2ea1bc7b758d9!8m2!3d43.5645767!4d3.8450909' 
                ],
                'financial' => [
                    'id' => 1,
                    'tag' => 'PSMIL',
                    'name' => 'Militaire',
                    'public_name' => 'Militaire'        
                ]
            ];

        $this->sendResponse("001", "User logged successfully", $user);

        }
    }

    /**
     * SIMULATION - LogIn
     * Specificity =>  lambda, employe(e) AFPA, null, AFPA
     * 
     * Response code 001 : user found and password is valid.
     * Response code 005 : missing information.
     * 
     */
    public function success_employee()
    {
        if($this->checkPostData()) {

            $user = [
                'id' => 2,
                'identifier' => '01020304',
                'lastName' => 'Rémi',
                'firstName' => 'Dupont',
                'mailPro' => 'remi.dupont@afpaconnect.fr',
                'mailPerso' => 'remi.dupont@wanadoo.fr',
                'phone' => '0606060606',
                'adress' => '2 rue de la rue',
                'complementAdress' => 'Batiment B',
                'zipCode' => '34000',
                'city' => 'Montpellier',
                'country' => 'France',
                'gender' => '0',
                'status' => '1',
                'created_at' => 20210430 ,
                'updated_at' => null,
                'role' => [
                    'id' => 1,
                    'tag' => 'ROLE_USER',
                    'name' => 'Rôle utilisateur'
                ],
                'function' => [
                    'id' => 2,
                    'tag' => 'EMPLOYE_AFPA',
                    'name' => 'Employé Afpa',
                    'start_at' => 20210505,
                    'end_at' => 20211212
                ], 
                'session' => [
                    [
                        'id' => 1,
                        'tag' => 'DWWM025',
                        'name' => 'Dev Web et Web Mobile 05/2021-12/2021',
                        'start_at' => 20210505,
                        'end_at' => 20211212,
                        'status'=> 1,
                        'formation' => [
                          'id' => 1,
                          'tag' => 'DWWM',
                          'name' => 'Développeur web et web mobile',
                          'degree' => 'degree',
                          'status' => 1
                        ]
                    ],
                
                ],
                'center' => [
                    'id'=> 1,
                    'name' => 'Saint-Jean de Védas',
                    'adress' => 'rue Jean Mermoz',
                    'complementAdress' => 'zone d\'activité' ,
                    'zipCode' => '34430',
                    'city'=> 'Saint-Jean de Védas',
                    'schedule'=> 'schedule',
                    'contactMail'=> 'contact@afpa.com',
                    'withdrawalPlace'=> 'withdrawalPlace',
                    'withdrawalSchedule'=> 'withdrawalSchedule',
                    'urlGoogleMap'=> 'https://www.google.com/maps/place/AFPA/@43.5645741,3.8428852,17z/data=!3m1!4b1!4m5!3m4!1s0x12b6b1e78790b019:0x5fe2ea1bc7b758d9!8m2!3d43.5645767!4d3.8450909' 
                ],
                'financial' => [
                    'id' => 5,
                    'tag' => 'AFPA',
                    'name' => 'Salarié Afpa',
                    'public_name' => 'Salarié Afpa'      
                ]
            ];

        
        $this->sendResponse("001", "User logged successfully - ", $user);
        
        }

    }
    /**
     * SIMULATION - LogIn
     * Specificity => admin, stagiaire, DWWM, CR 
     * 
     * Response code 001 : user found and password is valid.
     * Response code 005 : missing information.
     * 
     */
    public function success_admin()
    {
        if($this->checkPostData()) {

            $user = [
                'id' => 3,
                'identifier' => '01020304',
                'lastName' => 'Rémi',
                'firstName' => 'Dupont',
                'mailPro' => 'remi.dupont@afpaconnect.fr',
                'mailPerso' => 'remi.dupont@wanadoo.fr',
                'phone' => '0606060606',
                'adress' => '2 rue de la rue',
                'complementAdress' => 'Batiment B',
                'zipCode' => '34000',
                'city' => 'Montpellier',
                'country' => 'France',
                'gender' => '0',
                'status' => '1',
                'created_at' => 20210430 ,
                'updated_at' => null,
                'role' => [
                    'id' => 2,
                    'tag' => 'ROLE_ADMIN',
                    'name' => 'Rôle administrateur'
                ],
                'function' => [
                    'id' => 1,
                    'tag' => 'STAGIAIRE',
                    'name' => 'Stagiaire',
                    'start_at' => 20210505,
                    'end_at' => 20211212
                ], 
                'session' => [
                    [
                        'id' => 1,
                        'tag' => 'DWWM025',
                        'name' => 'Dev Web et Web Mobile 05/2021-12/2021',
                        'start_at' => 20210505,
                        'end_at' => 20211212,
                        'status'=> 1,
                        'formation' => [
                          'id' => 1,
                          'tag' => 'DWWM',
                          'name' => 'Développeur web et web mobile',
                          'degree' => 'degree',
                          'status' => 1
                        ]
                    ],
                
                ],
                'center' => [
                    'id'=> 1,
                    'name' => 'Saint-Jean de Védas',
                    'adress' => 'rue Jean Mermoz',
                    'complementAdress' => 'zone d\'activité' ,
                    'zipCode' => '34430',
                    'city'=> 'Saint-Jean de Védas',
                    'schedule'=> 'schedule',
                    'contactMail'=> 'contact@afpa.com',
                    'withdrawalPlace'=> 'withdrawalPlace',
                    'withdrawalSchedule'=> 'withdrawalSchedule',
                    'urlGoogleMap'=> 'https://www.google.com/maps/place/AFPA/@43.5645741,3.8428852,17z/data=!3m1!4b1!4m5!3m4!1s0x12b6b1e78790b019:0x5fe2ea1bc7b758d9!8m2!3d43.5645767!4d3.8450909' 
                ],
                'financial' => [
                    'id' => 5,
                    'tag' => 'Cr',
                    'name' => 'Conseil Régional',
                    'public_name' => 'Conseil Régional'      
                ]
            ];

        
            $this->sendResponse("001", "User logged successfully", $user);
        }
    }

    /**
     * SIMULATION - LogIn
     * Specificity => lambda, formateur, DWWM + CDA, AFPA
     * 
     * Response code 001 : user found and password is valid.
     * Response code 005 : missing information.
     * 
     */
    public function success_teacher()
    {
        if($this->checkPostData()) {

            $user = [
                'id' => 4,
                'identifier' => '01020304',
                'lastName' => 'Jean-Jacques',
                'firstName' => 'Pagan',
                'mailPro' => 'jj.pagan@afpaconnect.fr',
                'mailPerso' => 'jj.pagan@wanadoo.fr',
                'phone' => '0606060606',
                'adress' => '2 rue de la rue',
                'complementAdress' => 'Batiment B',
                'zipCode' => '34000',
                'city' => 'Montpellier',
                'country' => 'France',
                'gender' => '0',
                'status' => '1',
                'created_at' => 20210430 ,
                'updated_at' => null,
                'role' => [
                    'id' => 1,
                    'tag' => 'ROLE_USER',
                    'name' => 'Rôle utilisateur'
                ],
                'function' => [
                    'id' => 3,
                    'tag' => 'FORMATEUR',
                    'name' => 'Formateur',
                    'start_at' => 20180505,
                    'end_at' => null
                ], 
                'session' => [
                    [
                        'id' => 1,
                        'tag' => 'DWWM025',
                        'name' => 'Dev Web et Web Mobile 05/2021-12/2021',
                        'start_at' => 20210505,
                        'end_at' => 20211212,
                        'status'=> 1,
                        'formation' => [
                          'id' => 1,
                          'tag' => 'DWWM',
                          'name' => 'Développeur web et web mobile',
                          'degree' => 'degree',
                          'status' => 1
                        ]
                    ], [
                            'id' => 2,
                            'tag' => 'CDA01',
                            'name' => 'Concepteur développeur d\'application 01/2021-12/2021',
                            'start_at' => 20210105,
                            'end_at' => 20211231,
                            'status'=> 1,
                            'formation' => [
                              'id' => 1,
                              'tag' => 'CDA',
                              'name' => 'Concepteur développeur d\'application',
                              'degree' => 'degree',
                              'status' => 1
                            ]
                        ],
                
                ],
                'center' => [
                    'id'=> 1,
                    'name' => 'Saint-Jean de Védas',
                    'adress' => 'rue Jean Mermoz',
                    'complementAdress' => 'zone d\'activité' ,
                    'zipCode' => '34430',
                    'city'=> 'Saint-Jean de Védas',
                    'schedule'=> 'schedule',
                    'contactMail'=> 'contact@afpa.com',
                    'withdrawalPlace'=> 'withdrawalPlace',
                    'withdrawalSchedule'=> 'withdrawalSchedule',
                    'urlGoogleMap'=> 'https://www.google.com/maps/place/AFPA/@43.5645741,3.8428852,17z/data=!3m1!4b1!4m5!3m4!1s0x12b6b1e78790b019:0x5fe2ea1bc7b758d9!8m2!3d43.5645767!4d3.8450909' 
                ],
                'financial' => [
                    'id' => 5,
                    'tag' => 'AFPA',
                    'name' => 'Salarié Afpa',
                    'public_name' => 'Salarié Afpa'      
                ]
            ];
            $this->sendResponse("001", "User logged successfully", $user);
        }
    }

     /**
     * SIMULATION - LogIn
     * Specificity => admin, formateur, DWWM + CDA, AFPA
     * 
     * Response code 001 : user found and password is valid.
     * Response code 005 : missing information.
     * 
     */
    public function success_teacher_admin()
    {
        if($this->checkPostData()) {

            $user = [
                'id' => 4,
                'identifier' => '01020304',
                'lastName' => 'Jean-Jacques',
                'firstName' => 'Pagan',
                'mailPro' => 'jj.pagan@afpaconnect.fr',
                'mailPerso' => 'jj.pagan@wanadoo.fr',
                'phone' => '0606060606',
                'adress' => '2 rue de la rue',
                'complementAdress' => 'Batiment B',
                'zipCode' => '34000',
                'city' => 'Montpellier',
                'country' => 'France',
                'gender' => '0',
                'status' => '1',
                'created_at' => 20210430 ,
                'updated_at' => null,
                'role' => [
                    'id' => 2,
                    'tag' => 'ROLE_ADMIN',
                    'name' => 'Rôle administrateur'
                ],
                'function' => [
                    'id' => 3,
                    'tag' => 'FORMATEUR',
                    'name' => 'Formateur',
                    'start_at' => 20210505,
                    'end_at' => null
                ], 
                'session' => [
                    [
                        'id' => 1,
                        'tag' => 'DWWM025',
                        'name' => 'Dev Web et Web Mobile 05/2021-12/2021',
                        'start_at' => 20210505,
                        'end_at' => 20211212,
                        'status'=> 1,
                        'formation' => [
                          'id' => 1,
                          'tag' => 'DWWM',
                          'name' => 'Développeur web et web mobile',
                          'degree' => 'degree',
                          'status' => 1
                        ]
                    ], [
                            'id' => 2,
                            'tag' => 'CDA01',
                            'name' => 'Concepteur développeur d\'application 01/2021-12/2021',
                            'start_at' => 20210105,
                            'end_at' => 20211231,
                            'status'=> 1,
                            'formation' => [
                              'id' => 1,
                              'tag' => 'CDA',
                              'name' => 'Concepteur développeur d\'application',
                              'degree' => 'degree',
                              'status' => 1
                            ]
                        ],
                
                ],
                'center' => [
                    'id'=> 1,
                    'name' => 'Saint-Jean de Védas',
                    'adress' => 'rue Jean Mermoz',
                    'complementAdress' => 'zone d\'activité' ,
                    'zipCode' => '34430',
                    'city'=> 'Saint-Jean de Védas',
                    'schedule'=> 'schedule',
                    'contactMail'=> 'contact@afpa.com',
                    'withdrawalPlace'=> 'withdrawalPlace',
                    'withdrawalSchedule'=> 'withdrawalSchedule',
                    'urlGoogleMap'=> 'https://www.google.com/maps/place/AFPA/@43.5645741,3.8428852,17z/data=!3m1!4b1!4m5!3m4!1s0x12b6b1e78790b019:0x5fe2ea1bc7b758d9!8m2!3d43.5645767!4d3.8450909' 
                ],
                'financial' => [
                    'id' => 5,
                    'tag' => 'AFPA',
                    'name' => 'Salarié Afpa',
                    'public_name' => 'Salarié Afpa'      
                ]
            ];


            $this->sendResponse("001", "User logged successfully", $user);
        }
    }

    /**
     * SIMULATION - LogIn
     * Specificity => superadmin, formateur, DWWM + CDA, AFPA
     * 
     * Response code 001 : user found and password is valid.
     * Response code 005 : missing information.
     * 
     */
    public function success_teacher_superadmin()
    {
        if($this->checkPostData()) {

            $user = [
                'id' => 4,
                'identifier' => '01020304',
                'lastName' => 'Jean-Jacques',
                'firstName' => 'Pagan',
                'mailPro' => 'jj.pagan@afpaconnect.fr',
                'mailPerso' => 'jj.pagan@wanadoo.fr',
                'phone' => '0606060606',
                'adress' => '2 rue de la rue',
                'complementAdress' => 'Batiment B',
                'zipCode' => '34000',
                'city' => 'Montpellier',
                'country' => 'France',
                'gender' => '0',
                'status' => '1',
                'created_at' => 20210430 ,
                'updated_at' => null,
                'role' => [
                    'id' => 3,
                    'tag' => 'ROLE_SUPER_ADMIN',
                    'name' => 'Rôle super administrateur'
                ],
                'function' => [
                    'id' => 3,
                    'tag' => 'FORMATEUR',
                    'name' => 'Formateur',
                    'start_at' => 20210505,
                    'end_at' => null
                ], 
                'session' => [
                    [
                        'id' => 1,
                        'tag' => 'DWWM025',
                        'name' => 'Dev Web et Web Mobile 05/2021-12/2021',
                        'start_at' => 20210505,
                        'end_at' => 20211212,
                        'status'=> 1,
                        'formation' => [
                          'id' => 1,
                          'tag' => 'DWWM',
                          'name' => 'Développeur web et web mobile',
                          'degree' => 'degree',
                          'status' => 1
                        ]
                    ], [
                            'id' => 2,
                            'tag' => 'CDA01',
                            'name' => 'Concepteur développeur d\'application 01/2021-12/2021',
                            'start_at' => 20210105,
                            'end_at' => 20211231,
                            'status'=> 1,
                            'formation' => [
                              'id' => 1,
                              'tag' => 'CDA',
                              'name' => 'Concepteur développeur d\'application',
                              'degree' => 'degree',
                              'status' => 1
                            ]
                        ],
                
                ],
                'center' => [
                    'id'=> 1,
                    'name' => 'Saint-Jean de Védas',
                    'adress' => 'rue Jean Mermoz',
                    'complementAdress' => 'zone d\'activité' ,
                    'zipCode' => '34430',
                    'city'=> 'Saint-Jean de Védas',
                    'schedule'=> 'schedule',
                    'contactMail'=> 'contact@afpa.com',
                    'withdrawalPlace'=> 'withdrawalPlace',
                    'withdrawalSchedule'=> 'withdrawalSchedule',
                    'urlGoogleMap'=> 'https://www.google.com/maps/place/AFPA/@43.5645741,3.8428852,17z/data=!3m1!4b1!4m5!3m4!1s0x12b6b1e78790b019:0x5fe2ea1bc7b758d9!8m2!3d43.5645767!4d3.8450909' 
                ],
                'financial' => [
                    'id' => 5,
                    'tag' => 'AFPA',
                    'name' => 'Salarié Afpa',
                    'public_name' => 'Salarié Afpa'      
                ]
            ];

            $this->sendResponse("001", "User logged successfully", $user);
        }
    }



    /***
     * SIMULATION - LogIn
     * 
     * Response code 002 : user found without password.
     * Response code 005 : missing information.
     * 
    */
    public function blank()
    {
        if($this->checkPostData()) {

            $user = [
                'id' => 1,
                'identifier' => '01020304',
                'lastName' => 'Aufrere',
                'firstName' => 'Lucas',
                'mailPro' => 'lucas.aufrere@afpaconnect.fr',
                'mailPerso' => 'lucas.aufrere@wanadoo.fr',
                'phone' => '0606060606',
                'adress' => '2 rue de la rue',
                'complementAdress' => 'Batiment B',
                'zipCode' => '34000',
                'city' => 'Montpellier',
                'country' => 'France',
                'gender' => '0',
                'status' => '1',
                'created_at' => 20210430 ,
                'updated_at' => null,
                'role' => [
                    'id' => 1,
                    'tag' => 'ROLE_USER',
                    'name' => 'Rôle utilisateur'
                ],
                'function' => [
                    'id' => 1,
                    'tag' => 'STAGIAIRE',
                    'name' => 'stagiaire',
                    'start_at' => 20210505,
                    'end_at' => 20211212
                ], 
                'session' => [
                    [
                        'id' => 1,
                        'tag' => 'DWWM025',
                        'name' => 'Dev Web et Web Mobile 05/2021-12/2021',
                        'start_at' => 20210505,
                        'end_at' => 20211212,
                        'status'=> 1,
                        'formation' => [
                          'id' => 1,
                          'tag' => 'DWWM',
                          'name' => 'Développeur web et web mobile',
                          'degree' => 'degree',
                          'status' => 1
                        ]
                    ],
                
                ],
                'center' => [
                    'id'=> 1,
                    'name' => 'Saint-Jean de Védas',
                    'adress' => 'rue Jean Mermoz',
                    'complementAdress' => 'zone d\'activité' ,
                    'zipCode' => '34430',
                    'city'=> 'Saint-Jean de Védas',
                    'schedule'=> 'schedule',
                    'contactMail'=> 'contact@afpa.com',
                    'withdrawalPlace'=> 'withdrawalPlace',
                    'withdrawalSchedule'=> 'withdrawalSchedule',
                    'urlGoogleMap'=> 'https://www.google.com/maps/place/AFPA/@43.5645741,3.8428852,17z/data=!3m1!4b1!4m5!3m4!1s0x12b6b1e78790b019:0x5fe2ea1bc7b758d9!8m2!3d43.5645767!4d3.8450909' 
                ],
                'financial' => [
                    'id' => 1,
                    'tag' => 'PSMIL',
                    'name' => 'Militaire',
                    'public_name' => 'Militaire'        
                ]
            ];


            $this->sendResponse("002", "This user has never logged in one of the AFPA services : no password", $user);        
        }
    }

    
    /***
     * SIMULATION - LogIn
     * 
     * Response code 003 : user found but wrong password.
     * Response code 005 : missing information.
     * 
    */
    public function failed()
    {           
        if($this->checkPostData()) {

        $this->sendResponse("003", "Wrong password, please try again.", null); 

        }       
    }

    
    /***
     * SIMULATION - LogIn
     * 
     * Response code 004 : no user found
     * Response code 005 : missing information.
     * 
    */
    public function unfound()
    {

        if($this->checkPostData()) {

            $this->sendResponse("004", "User has not been found in our database", null);
            
        }
    }

    
    /*** 
     *  SIMULATION - PassRegister
     * 
     *  Response code 006 : password successfully register
     *  Response code 007 : wrong password format
     *  Response code 008 : user not found
     * 
     */
    public function inscription()
    {
        
            

        if(empty($this->request->request()->get('userId')) || empty($this->request->request()->get('password'))) {

            $this->sendResponse("008", 'Password or user not found in our database', null);
            
        } else {
    
            $this->sendResponse("006", "User has been successfully register ! Proceed to log in.", null);
        }
    
    }

    /*** 
     *  Check Post Data 
     * 
     *  @param string $statusCode, string $message, mixed $body
     * 
     */
    public function checkPostData() {
      
        if (!isset($this->userId) || !isset($this->password) || empty($this->userId) || empty($this->password)) {
            $this->sendResponse("005","Missing information, please try again.", null);
            return false;
            
        }            
            return true;
    }

    /*** 
     *  Set and send response 
     * 
     *  @param string $statusCode, string $message, mixed $body
     * 
     */
    public function sendResponse(string $statusCode, string $message, $body) {

        $this->response->setStatusCode($statusCode)
        ->setStatusMessage($message)
        ->setBodyContent($body)
        ->send();

    }

}
 