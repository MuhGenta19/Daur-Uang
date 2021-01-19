<?php

namespace App\Model;

use App\Traits\FormatDate;
use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    use FormatDate;

    protected $fillable = ['id_penarikan', 'id_penjualan', 'saldo', 'debit', 'kredit', 'keterangan'];
}
