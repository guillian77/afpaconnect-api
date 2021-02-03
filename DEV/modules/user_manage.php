<?php
namespace App\Controller;

use App\Core\Controller;
use function App\Core\debug;

class User_manage extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $test1 = "un test de dingue 1";
        $test2 = "un test de dingue 2";

        $this->render("user_manage", [
            'test1' => $test1,
            'test2' => $test2
        ]);
    }
}