<?php

namespace App\Http\Controllers\Users;

use Throwable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\PresensiService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class RsudController extends Controller
{
    protected $presensi;
    public function __construct(PresensiService $presensiService)
    {
        $this->presensi = $presensiService;
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $presensi = $this->presensi->Query()->where('user_id', $user->id)->latest()->first();

        if ($presensi && empty($presensi->jam_pulang)) {

            $currentTime = Carbon::now();

            $masukShiftPagi = Carbon::createFromTime(8, 0, 0);
            $pulangShiftPagi = Carbon::createFromTime(14, 0, 0);

            $masukShiftSiang = Carbon::createFromTime(14, 0, 0);
            $pulangShiftSiang = Carbon::createFromTime(20, 0, 0);

            $masukShiftMalam = Carbon::createFromTime(20, 0, 0);
            $pulangShiftMalam = Carbon::createFromTime(8, 0, 0)->addDay(); // Tambahkan 1 hari untuk shift malam

            if ($currentTime->between($masukShiftPagi, $pulangShiftPagi)) {
                $expectedTime = $pulangShiftPagi;
            } elseif ($currentTime->between($masukShiftSiang, $pulangShiftSiang)) {
                $expectedTime = $pulangShiftSiang;
            } else {
                $expectedTime = $pulangShiftMalam;
            }

            // Membuat objek Carbon untuk batas waktu pulang
            $batasWaktu = $expectedTime;

            // Memeriksa apakah waktu saat ini lebih besar atau sama dengan batas waktu yang diharapkan untuk pulang
            if ($currentTime->greaterThanOrEqualTo($batasWaktu)) {
                // Kondisi jika waktu saat ini sama atau lebih besar dari waktu yang diharapkan untuk pulang
                $statusPulang = 'Tepat waktu';
            } else {
                // Kondisi jika waktu saat ini lebih kecil dari waktu yang diharapkan untuk pulang
                $statusPulang = 'RSUD Menggala ' . $currentTime->format('H:i:s');
            }

            $presensiUpdate = $presensi->where('tanggal', $presensi->tanggal)->where('user_id', $user->id);
            $file = $request->file;
            if (strlen($file) > 30) {
                if (pathinfo($file, PATHINFO_EXTENSION) !== 'jpeg') {
                    $img =  $file;
                    $folderPath = "public/users/img/";

                    $image_parts = explode(";base64,", $img);
                    $image_type_aux = explode("image/", $image_parts[0]);
                    $image_type = $image_type_aux[1];

                    $image_base64 = base64_decode($image_parts[1]);
                    $fileName = uniqid() . '.jpeg';

                    $file = $folderPath . $fileName;
                    Storage::put($file, $image_base64);
                    $photo_pulang = $fileName;
                }
            } else {
                $photo_pulang = $file;
            }

            // Membuat objek Carbon untuk batas waktu pulang
            $batasWaktu = $expectedTime;

            // Memeriksa apakah waktu saat ini lebih besar atau sama dengan batas waktu yang diharapkan untuk pulang
            if ($currentTime->greaterThanOrEqualTo($batasWaktu)) {
                // Kondisi jika waktu saat ini sama atau lebih besar dari waktu yang diharapkan untuk pulang
                $statusPulang = 'Tepat waktu';
            } else {
                // Kondisi jika waktu saat ini lebih kecil dari waktu yang diharapkan untuk pulang
                $statusPulang = 'RSUD Menggala ' . $currentTime->format('H:i:s');
            }

            $data['opd_id']     = $user->opd_id;
            $data['user_id']    = $user->id;
            $data['tanggal']    = date('Y-m-d');
            $data['jam_pulang']  = date('H:i:s');
            $data['lat_long_pulang']  = $request->latLong;
            $data['photo_pulang']     = $photo_pulang;
            $data['status_pulang']     = $statusPulang;

            try {
                $this->presensi->update($presensiUpdate, $data);
            } catch (Throwable $e) {
                saveLogs($e->getMessage() . ' ' . 'presensi sore', 'error');
                return $this->error($e->getMessage());
            }
            return $this->success('OK', 'Anda Berhasil Mengisi Presensi Pulang');
        } else {
            $currentTime = Carbon::now();
            $waktuMasuk = Carbon::parse(env('JAM_MASUK'));

            $masukShiftPagi = Carbon::createFromTime(8, 00, 0);
            $pulangShiftPagi = Carbon::createFromTime(14, 00, 0);

            $masukShiftSiang = Carbon::createFromTime(14, 00, 0);
            $pulangShiftSiang = Carbon::createFromTime(20, 00, 0);

            $masukShiftMalam = Carbon::createFromTime(20, 00, 0);
            $pulangShiftMalam = Carbon::createFromTime(8, 00, 0);

            if ($currentTime->between($masukShiftPagi, $pulangShiftPagi)) {
                $jamMasuk = $masukShiftPagi;
            } elseif ($currentTime->between($masukShiftSiang, $pulangShiftSiang)) {
                $jamMasuk =  $masukShiftSiang;
            } elseif ($currentTime->between($masukShiftMalam, $pulangShiftMalam)) {
                $jamMasuk =  $masukShiftMalam;
            } else {
                $jamMasuk = $waktuMasuk;
            }

            if ($currentTime > $jamMasuk) {
                $telat = $currentTime->diff($jamMasuk);
                $status = 'Terlambat ' . $telat->format('%H:%I:%S');
            } else {
                $status = 'Tepat waktu';
            }

            $data = $request->except('_token');
            $file = $request->file;
            if (strlen($file) > 30) {
                if (pathinfo($file, PATHINFO_EXTENSION) !== 'jpeg') {
                    $img =  $file;
                    $folderPath = "public/users/img/";

                    $image_parts = explode(";base64,", $img);
                    $image_type_aux = explode("image/", $image_parts[0]);
                    $image_type = $image_type_aux[1];

                    $image_base64 = base64_decode($image_parts[1]);
                    $fileName = uniqid() . '.jpeg';

                    $file = $folderPath . $fileName;
                    Storage::put($file, $image_base64);
                    $photo_masuk = $fileName;
                }
            } else {
                $photo_masuk = $file;
            }

            $data['opd_id']     = $user->opd_id;
            $data['user_id']    = $user->id;
            $data['tanggal']    = date('Y-m-d');
            $data['jam_masuk']  = date('H:i:s');
            $data['lat_long_masuk']  = $request->latLong;
            $data['photo_masuk']     = $photo_masuk;
            $data['status'] = $status;

            try {
                $this->presensi->store($data);
            } catch (Throwable $e) {
                saveLogs($e->getMessage() . ' ' . 'presensi pagi', 'error');
                return $this->error($e->getMessage());
            }
            Presensicount();

            //clear cache
            Cache::forget('table_dashboard_' . Auth::user()->id);
            Cache::forget('hadir_' . Auth::user()->id);

            return $this->success($data, 'Anda Berhasil Mengisi Presensi Masuk');
        }
    }
}
