<?php

namespace App\Controller;

use App\Core\Controller;

class User_upload extends Controller
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
        parent::__construct();
        $this->render("user_upload");
    }
}