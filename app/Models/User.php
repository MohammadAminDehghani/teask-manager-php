<?php

namespace App\Models;

use App\Core\Model;

class User extends Model
{
    protected string $table = 'users';

    public int $id;
    public string $email;
    public string $password;
    public string $name;

}
