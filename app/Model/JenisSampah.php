<?php

namespace App\Model;

use App\Traits\FormatDate;
use Illuminate\Database\Eloquent\Model;

class JenisSampah extends Model
{
    use FormatDate;

    protected $fillable = ['nama_kategori', 'image', 'harga', 'stok_gudang'];

    // relasi
    public function penyetoran()
    {
        return $this->hasMany(Penyetoran::class);
    }

    public function sampah()
    {
        $this->hasOne('App\Model\Sampah', 'jenis_sampah', 'id');
    }
}
