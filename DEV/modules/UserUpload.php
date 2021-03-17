<?php

namespace App\Controller;

use App\Core\Controller;

class UserUpload extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->render("user_upload",['user_center_id' => $this->request->session()->get('user')['center']]);
    }
}
