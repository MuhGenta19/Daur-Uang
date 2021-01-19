<?php

namespace App\Http\Controllers\Api;

use App\Model\Jenis;
use GuzzleHttp\Client;
use App\Model\Penyetoran;
use App\Model\Penjemputan;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class PenyetoranController extends Controller
{
    public function store($fee = 0)
    {
        $data = request()->validate([
            'jenis_sampah' => 'required',
            'berat'        => 'required',
        ]);

        $harga = Jenis::find(request('jenis_sampah'));
        $data['penghasilan'] = $fee == 0 ? $harga->harga * $data['berat'] : $harga->harga * $data['berat'] - (($harga->harga * $data['berat']) * $fee / 100);

        $data['id_nasabah'] = Auth::id();

        // jika ada orang iseng 
        abort_if($data['id_nasabah'] != Auth::id(), 403, 'ANDA TIDAK MEMILIKI AKSES KESINI');

        $res = Penyetoran::create($data);

        // update buku tabungan & gudang sampah
        if ($res) {
            SampahController::addSampah($data);
            TransaksiController::addSaldo($data);
        } else {
            $this->sendResponse('Failed', 'Gagal Melakukan Permintaan', null, 400);
        }

        return $this->sendResponse('Success', 'Sampah berhasil dijual', $res, 201);
    }

    public function jemput(Client $client)
    {
        $data = request()->validate([
            // 'avatar' => 'required',
            'nama_pengirim'  => 'required',
            'lokasi'       => 'required',
            'telepon'  => 'required',
            'keterangan'   => 'required',
        ]);

        // Validasi image
        // $image = base64_encode(file_get_contents(request('avatar')));
        // $res = $client->request('POST', 'https://freeimage.host/api/1/upload', [
        //     'form_params' => [
        //         'key' => '6d207e02198a847aa98d0a2a901485a5',
        //         'action' => 'upload',
        //         'source' => $image,
        //         'format' => 'json'
        //     ]    
        // ]);
        // $get = $res->getBody()->getContents();
        // $hasil = json_decode($get);

        // // input image
        // $data['avatar'] = $hasil->image->display_url;

        // input user id
        $data['id_nasabah'] = Auth::id();

        // jika ada orang iseng
        abort_if($data['id_nasabah'] != Auth::id(), 403, 'ANDA TIDAK MEMILIKI AKSES KESINI');

        $res = Penjemputan::create($data);

        return $this->sendResponse('Success', 'Driver Sedang kelokasi Anda', $res, 200);
    }

    public function historyPenjemputan()
    {
        $data = Penjemputan::where('id_nasabah', Auth::id())->orderBy('status', 'ASC')->get();

        if (empty($data->array)) return $this->sendResponse();

        return $this->sendResponse('Success', 'History Berhasil dimuat', $data, 200);
    }
}
