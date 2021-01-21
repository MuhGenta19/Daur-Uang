<?php

namespace App\Http\Controllers\Api;

use App\Model\Penjemputan;
use App\Http\Controllers\Controller;

class PenjemputanController extends Controller
{
    public function index()
    {
        $permintaan = Penjemputan::with('user')->where('status', 0)->get();
        return $this->sendResponse('Success', 'daftar permintaan jemput :', $permintaan, 200);
    }

    public function selesai()
    {
        $permintaan = Penjemputan::with('user')->where('status', 1)->get();
        return $this->sendResponse('Success', 'daftar permintaan yang sudah dijemput :', $permintaan, 200);
    }

    public function penolakan()
    {
        $permintaan = Penjemputan::with('user')->where('status', 3)->get();
        return $this->sendResponse('Success', 'daftar penolakan jemput :', $permintaan, 200);
    }

    public function tolak(Penjemputan $penjemputan)
    {
        $penjemputan->update([
            'status'    => 3
        ]);

        return $this->sendResponse('Success', 'permintaan anda tolak', $penjemputan, 200);
    }

    public function konfirmasiPenjemputan(Penjemputan $penjemputan)
    {
        $penjemputan->update([
            'status'    => 1
        ]);

        return $this->sendResponse('Success', 'sampah berhasil dijemput', $penjemputan, 200);
    }
}
