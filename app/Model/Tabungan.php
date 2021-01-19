<?php

namespace App\Model;

use App\User;
use App\Traits\FormatDate;
use Illuminate\Database\Eloquent\Model;

class Tabungan extends Model
{
    use FormatDate;

    protected $fillable = ['jenis_sampah', 'debit', 'kredit', 'saldo', 'id_nasabah', 'berat'];

    // Relation
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
