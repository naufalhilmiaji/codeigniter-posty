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
            'status' => session()->get(),
        ];

        if (session()->get('logged_in') == 1) {
            session()->setFlashdata('alert', 'You have already logged in.');

            return redirect()->to(base_url('/'));
        }

        return view('auth/login', $data);
    }

    public function login()
    {
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $model = new User();
        $user = $model->getUser($email);

        if ($user) {
            $verify_pass = password_verify($password, $user['password']);

            if ($verify_pass) {
                session()->set([
                    'name' => $user['first_name'],
                    'email' => $user['email'],
                    'logged_in' => TRUE
                ]);
                return redirect()->to(base_url('/'));
            } else {
                session()->setFlashdata('error', 'Your credentials are invalid!');
                
                return redirect()->back();
            }            
        } else {
            session()->setFlashdata('error', 'Your credentials are invalid!');
            
            return redirect()->back();
        }
    }

    public function logout()
    {
        session()->start();
        session()->destroy();

        return redirect()->to(base_url('/login'));
    }
}
