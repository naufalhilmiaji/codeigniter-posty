<?php

namespace App\Models;

use CodeIgniter\Model;

class User extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'first_name',
        'last_name',
        'email',
        'password'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


    public function getUser($email = false, $password = false)
    {
        if ($email === false && $password === false) {
            return $this->findAll();
        } else {
            $result = $this->table('users')->where('email', $email)->find();
            if (count($result) > 0) {
                return $result[0];
            } else {
                return false;
            }
        }
    }

    public function getMyPosts($author = false)
    {
        $post = new Post();
        $my_posts = $post->where('author', $author)->orderBy('updated_at', 'DESC')->findAll();

        if ($my_posts) {
            return $my_posts;
        } else {
            return false;
        }
    }
}
