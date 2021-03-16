<?php
namespace App\Controller;

use App\Core\Controller;
use function App\Core\debug;

class UserManage extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->render("user_manage");
    }
}