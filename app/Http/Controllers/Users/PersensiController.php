<?php

namespace App\Http\Controllers\Users;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Services\PresensiService;
use App\Http\Controllers\Controller;
use App\Jobs\PresensiJob;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PersensiController extends Controller
{

    protected $presensi;
    public function __construct(PresensiService $presensiService)
    {
        $this->presensi = $presensiService;
    }
    public function index()
    {
        $data['title'] = 'Isi Presensi';
        $data['nama'] = explode(" ", Auth::user()->nama);
        $data['lat'] = Auth::user()->opd->lat;
        $data['long'] = Auth::user()->opd->long;
        return view('users.persensi.index', $data);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $presensi = $this->presensi->Query()->where('user_id', $user->id)->latest()->first();

        if ($presensi && $presensi->tanggal == date('Y-m-d')) {

            if (strtotime(date('H:i:s')) < strtotime(env('JAM_PULANG'))) {
                return $this->error('Mohon Maaf Presensi Sore Belum Dibuka!');
            }

            if (isset($presensi->jam_pulang)) {
                return $this->error('Hari Ini Anda Sudah Mengisi Presensi 2X!');
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

            $data['opd_id']     = $user->opd_id;
            $data['user_id']    = $user->id;
            $data['tanggal']    = date('Y-m-d');
            $data['jam_pulang']  = date('H:i:s');
            $data['lat_long_pulang']  = $request->latLong;
            $data['photo_pulang']     = $photo_pulang;

            try {
                $this->presensi->update($presensiUpdate, $data);
            } catch (Throwable $e) {
                saveLogs($e->getMessage() . ' ' . 'presensi sore', 'error');
                return $this->error($e->getMessage());
            }
            return $this->success('OK', 'Anda Berhasil Mengisi Presensi Sore');
        } else {
            $currentTime = Carbon::now();
            $jamMasuk = Carbon::parse(env('JAM_MASUK'));

            if ($currentTime > $jamMasuk) {
                $telat = $currentTime->diff($jamMasuk);
                $status = $telat->format('%H:%I:%S');
            } else {
                $status = null;
            }


            // if (strtotime(date('H:i:s')) > strtotime(env('JAM_MASUK'))) {
            //     $waktu_presensi = Carbon::now();
            //     $jam_masuk = Carbon::parse(env('JAM_MASUK'));
            //     $telat = $waktu_presensi->diff($jam_masuk);
            //     $status = $telat->h ? $telat->h . ':' . $telat->i . ':' . $telat->s : $telat->i . ':' . $telat->s;
            // } else {
            //     $status = NULL;
            // };

            $data = $request->except('_token');
            $data['status'] = $status;

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

            try {
                dispatch(new PresensiJob($data));
                // $this->presensi->store($data);
            } catch (Throwable $e) {
                saveLogs($e->getMessage() . ' ' . 'presensi pagi', 'error');
                return $this->error($e->getMessage());
            }
            return $this->success($data, 'Anda Berhasil Mengisi Presensi Pagi');
        }
    }

    public function storeFile(Request $request)
    {
        $img =  $request->image;
        $folderPath = "public/users/img/";

        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);
        $fileName = uniqid() . '.jpeg';

        $file = $folderPath . $fileName;
        Storage::put($file, $image_base64);
        return $this->success($fileName);
    }

    public function removeFile(Request $request)
    {
        unlink(('public/users/img/' . $request->file));
    }
}
