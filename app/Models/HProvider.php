<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HProvider extends Model
{
    protected $connection = 'homis';
    protected $table = 'hprovider';
    use HasFactory;

    public function hpersonal()
    {
        return $this->hasOne(HPersonal::class, 'employeeid', 'employeeid');
    }
}
