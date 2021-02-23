<?php
namespace App\Controller;

use App\Core\Controller;

class token extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->render('token');
    }
}
