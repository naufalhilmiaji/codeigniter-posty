<?php

namespace App\Models;

use CodeIgniter\Model;

class Post extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'post';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;

    public function getPost($id = false)
    {
        if($id === false){
            return $this->orderBy('updated_at', 'DESC')->findAll();
        }else{
            return $this->getWhere(['post_id' => $id]);
        }
    }

    public function savePost($data)
    {
        $query = $this->db->table($this->table)->insert($data);
        return $query;
    }

    public function updatePost($data, $id)
    {
        $query = $this->db->table($this->table)->update($data, array('post_id' => $id));
        return $query;
    }
 
    public function deletePost($id)
    {
        $query = $this->db->table($this->table)->delete(array('post_id' => $id));
        return $query;
    } 

    public function searchPost($term)
    {

        if ($term != '') {
            return $this->table('post')->like('LOWER(body)', strtolower($term))->findAll();
        }
    }
}
