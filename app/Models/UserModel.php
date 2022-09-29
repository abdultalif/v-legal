<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'user_id';
    protected $useTimestamps = true;

    protected $allowedFields = ['name', 'username', 'password', 'role', 'email', 'status', 'foto'];

    public function get($id = null)
    {
        $this->orderBy('name', 'asc');

        if (!$id) {
            return $this->findAll();
        }

        return $this->where(['user_id' => $id])->first();
    }

    public function getUserClient()
    {
        $query = $this->query("SELECT users.* FROM users WHERE NOT EXISTS(SELECT user_id FROM client WHERE client.user_id=users.user_id)");
        return $query->getResultArray();
    }

    public function getUserByUsername($username = null)
    {
        return $this->where(['username' => $username])->first();
    }

    public function cekEmail($email)
    {
        return $this->where(['email'=>$email])->first();
    }
}
