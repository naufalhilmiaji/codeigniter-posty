<?php
namespace App\Libraries;

class ValidateLogin
{
    public function is_loggedin()
    {
        if (session()->get('logged_in') == 0) {
            session()->setFlashdata('login', 'You must login first!');

            return false;
        } else {
            return true;
        }
    }
}

?>