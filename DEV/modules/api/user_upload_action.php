<?php

namespace App\Api;
use App\Utility\Response;
use App\Utility\Upload;
use App\Service\User;


class User_upload_action
{
    /**
     * @var array
     */
    public $VARS_HTML;

    /**
     * @var array
     */
    public $errors = [];

    public function __construct()
    {
        // Load User service
        $User = new User();
        $this->VARS_HTML = $User->VARS_HTML;
        
        $isXLS = ($_FILES["fileToUpload"]['type'] === "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" ||
        $_FILES["upload_user"]['type'] === "application/vnd.ms-excel"  ? true : false);

        if(isset($this->VARS_HTML['center']) && $this->VARS_HTML['center'] != null && $isXLS){
            $tmp_name = $_FILES["fileToUpload"]["tmp_name"];
            $content = Upload::parse($tmp_name);
            echo json_encode($content,JSON_FORCE_OBJECT|JSON_UNESCAPED_UNICODE);
        }
        

    }
}
