<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HPersonal extends Model
{
    protected $connection = 'homis';
    protected $table = 'hpersonal';

    use HasFactory;

    public function hprovider()
    {
        return $this->belongsTo(HProvider::class, 'employeeid', 'employeeid');
    }
}
