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

        if (empty($presensi->jam_pulang)) {
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
            $data['status_pulang']     = 'Jam pulang ' . date('H:i:s');

            try {
                $this->presensi->update($presensiUpdate, $data);
            } catch (Throwable $e) {
                saveLogs($e->getMessage() . ' ' . 'presensi sore', 'error');
                return $this->error($e->getMessage());
            }
            //clear cache
            Cache::forget('table_dashboard_' . Auth::user()->id);
            Cache::forget('hadir_' . Auth::user()->id);
            return $this->success('OK', 'Anda Berhasil Mengisi Presensi Pulang');
            
        }else {
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
            $data['status'] = 'Jam masuk ' . date('H:i:s');

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
            return $this->success($data, 'Anda Berhasil Mengisi Presensi masuk');
        }
    }
}
