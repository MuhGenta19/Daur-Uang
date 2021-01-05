<?php

namespace App\Http\Controllers;

use Auth;
use Alert;
use App\User;
use Illuminate\Http\Request;
use Hash;
use GuzzleHttp\Client;

class ProfileController extends Controller
{
	public function index()
	{
		$user = User::where('id', Auth::user()->id)->first();
		if (Empty($user)) {
			return response('login terlebih dahulu');
		}
		return $this->sendResponse('Success', 'ini dia profil anda', $user, 200);
	}

	public function update(Request $request)
	{
		$this->validate($request, [
			'password'  => 'confirmed',
		]);
		$image = null;

		if ($request->image) {
			$img = base64_encode(file_get_contents($request->image));
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
		$user->nama_lengkap = $request->name_lengkap ?? $user->name;
		$user->telepon = $request->telepon;
		$user->lokasi = $request->lokasi;
		$user->avatar = $request->image ? $image : Auth::user()->avatar;

		if (!empty($request->password)) {
			$user->password = Hash::make($request->password);
		}

		$user->update();
		return $this->sendResponse('Success', 'update profil berhasil', $user, 200);
	}

	public function change(Request $request)
	{
		$user = User::where('id', Auth::user()->id)->first();
		if (!empty($user)) {
			if (password_verify($request->password, $user->password)) {
				$user->password = $request->password_change;
				if (!empty($request->password_change)) {
					$user->password = hash::make($request->password_change);
				}
				$user->update();
				return $this->sendResponse('success', 'berhasil ganti password', $user, 200);
			} else {
				return $this->sendResponse('error', 'masukkan password lama', null, 404);
			}
		}
	}
}
