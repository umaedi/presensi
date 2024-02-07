<?php

namespace App\Http\Controllers\Users;

use Throwable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\RsudService;
use App\Http\Controllers\Controller;
use App\Services\PresensiService;
use Illuminate\Support\Facades\Auth;
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

            $masukShiftPagi = Carbon::createFromTime(8, 00, 0);
            $pulangShiftPagi = Carbon::createFromTime(14, 00, 0);

            $masukShiftSiang = Carbon::createFromTime(14, 00, 0);
            $pulangShiftSiang = Carbon::createFromTime(20, 00, 0);

            $masukShiftMalam = Carbon::createFromTime(20, 00, 0);
            $pulangShiftMalam = Carbon::createFromTime(8, 00, 0);

            if ($currentTime->between($masukShiftPagi, $pulangShiftPagi)) {
                $jamPulang = $pulangShiftPagi;
                $pesan = 'Shift Pagi';
            } elseif ($currentTime->between($masukShiftSiang, $pulangShiftSiang)) {
                $jamPulang =   $pulangShiftSiang;
                $pesan = 'Shift Siang';
            } elseif ($currentTime->between($masukShiftMalam, $pulangShiftMalam)) {
                $jamPulang =  $pulangShiftMalam;
                $pesan = 'Shift Malam';
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

            // Membuat objek Carbon untuk pukul 15:30:00
            $batasWaktu = $jamPulang;

            // Memeriksa apakah waktu saat ini lebih kecil dari $batasWaktu
            if ($currentTime->lessThan($batasWaktu)) {
                // Kondisi jika waktu saat ini lebih kecil dari 15:30:00
                $statusPulang = 'Lebih awal ' . date('H:i:s');
            } else {
                // Kondisi jika waktu saat ini sama atau lebih besar dari 15:30:00
                $statusPulang = 'Tepat waktu';
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
            return $this->success('OK', 'Anda Berhasil Mengisi Presensi Pulang ' . $pesan);
        } else {
            $currentTime = Carbon::now();

            $masukShiftPagi = Carbon::createFromTime(8, 00, 0);
            $pulangShiftPagi = Carbon::createFromTime(14, 00, 0);

            $masukShiftSiang = Carbon::createFromTime(14, 00, 0);
            $pulangShiftSiang = Carbon::createFromTime(20, 00, 0);

            $masukShiftMalam = Carbon::createFromTime(20, 00, 0);
            $pulangShiftMalam = Carbon::createFromTime(8, 00, 0);

            if ($currentTime->between($masukShiftPagi, $pulangShiftPagi)) {
                $jamMasuk = $masukShiftPagi;
                $pesan = 'Shift Pagi';
            } elseif ($currentTime->between($masukShiftSiang, $pulangShiftSiang)) {
                $jamMasuk =  $masukShiftSiang;
                $pesan = 'Shift Siang';
            } elseif ($currentTime->between($masukShiftMalam, $pulangShiftMalam)) {
                $jamMasuk =  $masukShiftMalam;
                $pesan = 'Shift Malam';
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
                // dispatch(new PresensiJob($data));
                $this->presensi->store($data);
            } catch (Throwable $e) {
                saveLogs($e->getMessage() . ' ' . 'presensi pagi', 'error');
                return $this->error($e->getMessage());
            }
            Presensicount();
            return $this->success($data, 'Anda Berhasil Mengisi Presensi Masuk ' . $pesan);
        }
    }
}
