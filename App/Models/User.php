<?php

namespace App\Models;

use Nevs\Model;

class User extends Model
{
    public function __construct()
    {
        parent::__construct();

        $this->table = 'users';
        $this->hidden = ['password'];
    }
}