<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User;

class Login extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Login Page',
        ];

        return view('login', $data);
    }

    public function login()
    {
        if (isset($_POST['submit'])) {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }

        $model = new User();
        $user = $model->getUser($email);

        if ($user) {
            session()->set([
                'name' => $user['first_name'],
                'email' => $user['email'],
                'password' => hash('md5', $user['password']),
                'logged_in' => TRUE
            ]);
            
            return redirect()->to(base_url('/'));
        } else {
            session()->setFlashdata('error', 'Your credentials are invalid!');
            
            return redirect()->back();
        }
    }

    public function logout()
    {
        session()->start();
        session()->destroy();

        return redirect()->to(base_url('/login'))->with('msg', 'You have already logged out.');
    }
}
