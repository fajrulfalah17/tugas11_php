<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $table = 'table_karyawan';
    protected $fillable = [
        'nama',
        'jabatan',
        'umur',
        'alamat',
        'foto'
    ];
}
