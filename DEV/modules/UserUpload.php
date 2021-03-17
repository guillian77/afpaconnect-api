<?php

namespace App\Controller;

use App\Core\Controller;

class UserUpload extends Controller
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
        $this->render("user_upload",['user_center_id' => $this->request->session(['user']['center'])]);
    }
}
