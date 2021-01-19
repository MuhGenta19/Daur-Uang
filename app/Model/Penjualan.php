<?php

namespace App\Model;

use App\Traits\FormatDate;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use FormatDate;

    protected $fillable = ['tanggal', 'id_pengurus', 'jenis_sampah', 'berat', 'harga_satuan', 'debit', 'client'];

    // relation
    public function jenis()
    {
        return $this->belongsTo(JenisSampah::class, 'nama_kategori');
    }
}
