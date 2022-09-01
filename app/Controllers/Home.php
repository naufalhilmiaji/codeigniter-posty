<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Post;

class Home extends BaseController
{
    public function index()
    {
        if (session()->get('logged_in') == 0) {
            session()->setFlashdata('login', 'You must login first!');

            return redirect()->to(base_url('/login'));
        }

        $model = new Post();
        $post = $model->getPost();
        $the_post = $model->searchPost('first');

        $data = [
            'title' => 'Posty PHP',
            'user' => 'Naufal Hilmiaji',
            'posts' => $post,
            'search' => $the_post,
        ];
        
        return view('index', $data);
    }

    public function upload()
    {
        $model = new Post();
        $data = array(
            'body' => $this->request->getPost('body'),
            'author' => 'Naufal'
        );
        
        $model->savePost($data);
        return redirect()->to(base_url('/'));
    }

    public function edit($id)
    {
        $model = new Post();
        $data = array(
            "body" => $model->getPost($id)->getRow(),
        );
        return json_encode($data);
    }
 
    public function update($id)
    {
        $model = new Post();
        $data = array(
            'body' => $this->request->getPost('body_edit'),
            'author' => $this->request->getPost('author_edit'),
        );
        $model->updatePost($data, $id);
        return redirect()->to(base_url('/'));
    }

    public function delete($id)
    {
        $model = new Post();
        $model->deletePost($id);
        return redirect()->to(base_url('/'));
    }

    public function search()
    {
        $term = $this->request->getVar('q');

        $model = new Post();
        $q_result = $model->searchPost($term);

        $data = array(
            'body' => $q_result,
        );

        return json_encode($data);
    }

}
