<?php

namespace App\Http\Controllers\Api;

use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
	public function show($id)
    {
        $data = User::findOrFail($id);

        return $this->sendResponse('Success', 'Data User :', $data, 200);
    }

    public function index()
    {
        $user = User::where('id', Auth::user()->id)->first();
        if (empty($user)) {
            return response('login terlebih dahulu!');
        }
        return $this->sendResponse('Success', 'profil anda :', $user, 200);
    }
    public function update(Request $request)
    {
        $this->validate($request, [
            'phone_number'  => 'required|string|min:8',
            'name'          => 'required'
        ]);

        if ($request->avatar) {
            $img = base64_encode(file_get_contents($request->avatar));
            $client = new Client();
            $res = $client->request('POST', 'https://freeimage.host/api/1/upload', [
                'form_params' => [
                    'key' => '6d207e02198a847aa98d0a2a901485a5',
                    'action' => 'upload',
                    'source' => $img,
                    'format' => 'json',
                ]
            ]);
            $array = json_decode($res->getBody()->getContents());
            $image = $array->image->file->resource->chain->image;
        }

        $user = User::where('id', Auth::user()->id)->first();

        $user->name = request('name') ?? $user->name;
        $user->avatar = request('avatar') ? $image : $user->avatar;

        $user->phone_number = $request->phone_number;
        // $user->address = $request->address;

        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }

        $user->update();
        return $this->sendResponse('Success', 'berhasil mengupdate profil', $user, 200);
    }
    public function change(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();
        if (!empty($user)) {
            if (password_verify($request->password, $user->password)) {
                $user->password = $request->password_change;
                if (!empty($request->password_change)) {
                    $user->password = Hash::make($request->password_change);
                }
                $user->update();
                return $this->sendResponse('Success', 'berhasil mengganti password', $user, 200);
            } else {
                return $this->sendResponse('Error', 'masukkan password lama', null, 400);
            }
        }
    }
}
