<?php

namespace App\Models;

use CodeIgniter\Model;

class TokenModel extends Model
{
    protected $table      = 'user_token';
    protected $primaryKey = 'token_id';
    protected $useTimestamps = false;

    protected $allowedFields = ['token_id', 'user_id', 'token', 'tipe', 'expired'];
}
