<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Welcome extends BaseController
{

    public function welcome()
    {
        return view('welcome_message');
    }

}
