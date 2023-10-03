<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPrivelege extends Model
{
    protected $connection = 'users';
    protected $table = 'user_priv';
    use HasFactory;
}
