<?php

require $config['PATH_CLASS'] . "services/user.php";
require $config['PATH_CLASS'] . "utilities/Upload.php";

class User_upload
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

        $isXLS = ($_FILES['type'] === "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" ||
        $_FILES['type'] === "application/vnd.ms-excel"  ? true : false);
        
        if(isset($this->VARS_HTML['center']) && $this->VARS_HTML['center'] != null && $isXLS){

            $tmp_name = $_FILES["upload_user"]["tmp_name"];
            $content = Upload::parse($tmp_name);
            if(is_array($content)){
                foreach($content as $val)
                {
                    echo'<pre>';var_dump($val);echo'</pre>';
                }
            }
            die;

        }
        header('Location: user_manage');
    }
}
