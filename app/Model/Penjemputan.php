<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Penjemputan extends Model
{
    protected $fillable = ['id_nasabah', 'nama_pengirim', 'telepon', 'lokasi', 'status'];

    // relation
    public function user()
    {
        return $this->belongsTo('App\User', 'id_nasabah', 'id');
    }
}
