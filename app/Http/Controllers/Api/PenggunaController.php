<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PenggunaResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PenggunaController extends Controller
{
    public function showPengguna()
    {
        $data = User::count();

        return new PenggunaResource(true, 'Total Pengguna', $data);
    }

    public function getPengguna()
    {
        $berkas = User::get();

        return response()->json($berkas);
    }

    public function getPenggunaById(Request $request)
    {
        $berkas = User::where('id', $request->id)->first();

        return response()->json($berkas);
    }

    public function sendPengguna(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'level' => 'required',
        ]);

        $data = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'level' => $request->level,
        ]);

        return new PenggunaResource(true, 'Berhasil Menambahkan Pengguna', $data);
    }

    public function deletePengguna(Request $request)
    {
        $berkas = User::where('id', $request->id)->delete();

        return response()->json($berkas);
    }

    public function updatePengguna(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'level' => 'required',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'level' => $request->level,
        ];

        if ($request->password != "") {
            $data['password'] = Hash::make($request->password);
        }

        $berkas = User::where('id', $request->id)->update($data);

        return new PenggunaResource(true, 'Berhasil Menambahkan Akta', $berkas);
    }
}
