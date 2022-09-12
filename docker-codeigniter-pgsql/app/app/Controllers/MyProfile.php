<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User;

class MyProfile extends BaseController
{
    public function index()
    {
        if (session()->get('logged_in') == 0) {
            session()->setFlashdata('login', 'You must login first!');

            return redirect()->to(base_url('/login'));
        }

        $model = new User();
        $posts = $model->getMyPosts(session()->get('name'));

        $data = [
            'title' => 'My Profile',
            'posts' => $posts,
        ];
        
        return view('my_posts', $data);
    }
}
