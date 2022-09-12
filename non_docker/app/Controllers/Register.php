<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User;

class Register extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Register Page',
        ];

        if (session()->get('logged_in') == 1) {
            session()->setFlashdata('alert', 'You have already logged in.');

            redirect()->to(base_url('/'));
        }

        return view('auth/register', $data);
    }

    public function register()
    {
        $rules = [
            'first_name'    => 'required|min_length[3]|max_length[20]',
            'last_name'     => 'required|min_length[3]|max_length[20]',
            'email'         => 'required|min_length[6]|max_length[50]|valid_email|is_unique[users.email]',
            'password'      => 'required|min_length[6]|max_length[200]',
            'confirmation' => 'matches[password]'
        ];

        if ($this->validate($rules)) {
            $model = new User();
            $data = [
                'first_name'    => $this->request->getVar('first_name'),
                'last_name'     => $this->request->getVar('last_name'),
                'email'         => $this->request->getVar('email'),
                'password'      => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)
            ];
            $model->save($data);
            return redirect()->to('/login');
        } else {
            session()->setFlashdata('error', $this->validator->listErrors());

            return redirect()->back();
        }
    }
}
