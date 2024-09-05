<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BerkasResource;
use Illuminate\Http\Request;
use App\Models\Berkas;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class BerkasController extends Controller {
    public function showArsip() {
        $berkas = Berkas::count();

        return new BerkasResource(true, 'Arsip Selesai', $berkas);
    }

    public function showArsipNow() {
        $currentMonth = Carbon::now()->month;
        $berkas = Berkas::whereMonth('created_at', $currentMonth)
            ->count();

        return new BerkasResource(true, 'Arsip Selesai', $berkas);
    }

    public function getByIdArsip(Request $request) {
        $berkas = Berkas::where('kode_berkas', $request->kode_berkas)->first();

        return response()->json($berkas);
    }

    public function deleteByIdArsip(Request $request) {
        $berkas = Berkas::where('kode_berkas', $request->kode_berkas)->delete();

        return response()->json($berkas);
    }

    public function showSelesaiArsip() {
        $berkas = Berkas::where('status_berkas', 'selesai')->count();

        return new BerkasResource(true, 'Arsip Selesai', $berkas);
    }

    public function showSetujuArsip() {
        $berkas = Berkas::where('status_berkas', 'disetujui')->count();

        return new BerkasResource(true, 'Arsip Selesai', $berkas);
    }

    public function showDitolakArsip() {
        $berkas = Berkas::where('status_berkas', 'ditolak')->count();

        return new BerkasResource(true, 'Arsip Ditolak', $berkas);
    }

    public function showValidasiArsip() {
        $berkas = Berkas::where('status_berkas', 'validasi')->count();

        return new BerkasResource(true, 'Arsip Validasi', $berkas);
    }

    public function getArsip() {
        $berkas = Berkas::get();

        return response()->json($berkas);
    }

    public function getSelesaiArsip() {
        $berkas = Berkas::where('status_berkas', 'selesai')->get();

        return response()->json($berkas);
    }

    public function getSetujuArsip() {
        $berkas = Berkas::where('status_berkas', 'disetujui')->get();

        return response()->json($berkas);
    }

    public function getDitolakArsip() {
        $berkas = Berkas::where('status_berkas', 'ditolak')->get();

        return response()->json($berkas);
    }

    public function getValidasiArsip() {
        $berkas = Berkas::where('status_berkas', 'validasi')->get();

        return response()->json($berkas);
    }

    public function sendBerkas(Request $request) {
        $validator = Validator::make($request->all(), [
            'nama_pihak_pertama' => 'required',
            'nama_pihak_kedua' => 'required',
            'jenis_berkas'     => 'required',
            'ktp_pihak_pertama' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'ktp_pihak_kedua' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'kk_pihak_pertama' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'kk_pihak_kedua' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'dokumen_pendukung' => 'required|mimes:pdf',
        ]);

        $ktp_pertama = $request->file('ktp_pihak_pertama');
        $nama_ktp_pertama = $ktp_pertama->hashName();
        $ktp_pertama->storeAs('public/ktp-pertama', $nama_ktp_pertama);

        $ktp_kedua = $request->file('ktp_pihak_kedua');
        $nama_ktp_kedua = $ktp_kedua->hashName();
        $ktp_kedua->storeAs('public/ktp-kedua', $nama_ktp_kedua);

        $kk_pertama = $request->file('kk_pihak_pertama');
        $nama_kk_pertama = $kk_pertama->hashName();
        $kk_pertama->storeAs('public/kk-pertama', $nama_kk_pertama);

        $kk_kedua = $request->file('kk_pihak_kedua');
        $nama_kk_kedua = $kk_kedua->hashName();
        $kk_kedua->storeAs('public/kk-kedua', $nama_kk_kedua);

        $dokumen_pendukung = $request->file('dokumen_pendukung');
        $nama_dokumen_pendukung = $dokumen_pendukung->hashName();
        $dokumen_pendukung->storeAs('public/dokumen_pendukung', $nama_dokumen_pendukung);

        $kode_berkas = "B-" . mt_rand(100000, 999999);

        $berkas = Berkas::create([
            'kode_berkas' => $kode_berkas,
            'nama_pihak_pertama' => $request->nama_pihak_pertama,
            'nama_pihak_kedua' => $request->nama_pihak_kedua,
            'jenis_berkas'     => $request->jenis_berkas,
            'file_ktp_pihak_pertama' => $nama_ktp_pertama,
            'file_ktp_pihak_kedua' => $nama_ktp_kedua,
            'file_kk_pihak_pertama' => $nama_kk_pertama,
            'file_kk_pihak_kedua' => $nama_kk_kedua,
            'file_dokumen_pendukung' => $nama_dokumen_pendukung,
            'status_berkas' => "validasi",
            'tanggal_berkas' => date('Y-m-d'),
            'tanggal_akta' => date('Y-m-d'),
            'no_akta' => "",
            'file_akta' => ""
        ]);

        return new BerkasResource(true, 'Berhasil Menambahkan Berkas', $berkas);
    }

    public function updateBerkasAkta(Request $request) {
        $validator = Validator::make($request->all(), [
            'no_akta' => 'required',
            'tanggal_akta' => 'required',
            'file_akta' => 'required|mimes:pdf',
        ]);

        $file_akta = $request->file('file_akta');
        $nama_file_akta = $file_akta->hashName();
        $file_akta->storeAs('public/file_akta', $nama_file_akta);

        $kode_berkas = $request->kode_berkas;

        $berkas = Berkas::where('kode_berkas', $kode_berkas)->update([
            'tanggal_akta' => $request->tanggal_akta,
            'no_akta' => $request->no_akta,
            'file_akta' => $nama_file_akta,
            'status_berkas' => "selesai"
        ]);

        return new BerkasResource(true, 'Berhasil Menambahkan Akta', $berkas);
    }

    public function getPhoto() {
        return response()->file(public_path('/storage/ktp-pertama/vFcDUmHuU7KCY5TlKXZovnnCcxbFMoMxzYgmciNi.jpg'));
    }

    public function setStatusBerkas(Request $request) {
        $validator = Validator::make($request->all(), [
            'kode_berkas' => 'required',
            'status_berkas' => 'required'
        ]);

        $kode_berkas = $request->kode_berkas;
        $status = $request->status_berkas;

        $berkas = Berkas::where('kode_berkas', $kode_berkas)->update([
            'status_berkas' => $status
        ]);

        return new BerkasResource(true, 'Berhasil Menambahkan Akta', $berkas);
    }
}
