<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\Hasfactory;
use Illuminate\Database\Eloquent\Model;

class Distributor extends Model
{
    use Hasfactory;

    protected $fillable = [
        'nama_distributor', 'kota', 'provinsi', 'kontak', 'email'
    
    ];
    //
}
