<?php

namespace App\Http\Controllers\Users;

use Throwable;
use App\Jobs\PresensiJob;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Jobs\UpdatepresensiJob;
use App\Services\PresensiService;
use App\Http\Controllers\Controller;
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
        $data['nama'] = explode(" ", auth()->user()->nama);
        return view('users.persensi.index', $data);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $presensi = $this->presensi->Query()->where('user_id', $user->id)->first();

        if ($presensi && $presensi->tanggal == date('Y-m-d')) {

            if (strtotime(date('H:i:s')) < strtotime('10:30:00')) {
                return $this->error('Mohon Maaf Absen Sore Belum Dibuka!');
            }

            if (isset($presensi->jam_pulang)) {
                return $this->error('Hari Ini Anda Sudah Mengisi Absen 2X!');
            }

            $presensiUpdate = $presensi->where('tanggal', $presensi->tanggal);
            $presensiUpdate->where('user_id', $presensi->user_id);

            $file = $request->file;
            if (pathinfo($file, PATHINFO_EXTENSION) !== 'jpeg') {
                $img =  $request->image;
                $folderPath = "public/users/img/";

                $image_parts = explode(";base64,", $img);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];

                $image_base64 = base64_decode($image_parts[1]);
                $fileName = uniqid() . '.jpeg';

                $file = $folderPath . $fileName;
                Storage::put($file, $image_base64);
                $photo_pulang = $fileName;
            } else {
                $photo_pulang = $request->file;
            }

            $data['opd_id']     = auth()->user()->opd_id;
            $data['user_id']    = auth()->user()->id;
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

            return $this->success('', 'Anda Berhasil Mengisi Absen Sore');
        } else {

            if (strtotime(date('H:i:s')) > strtotime('13:00:00')) {
                $waktu_presensi = Carbon::now();
                $jam_masuk = Carbon::parse('13:00:00');
                $telat = date_diff($waktu_presensi, $jam_masuk);
                $status = $telat->h ? $telat->h . ':' . $telat->i . ':' . $telat->s : $telat->i . ':' . $telat->s;
            } else {
                $status = "";
            };

            $data = $request->except('_token');
            $data['status'] = $status;

            $file = $request->file;
            if (pathinfo($file, PATHINFO_EXTENSION) !== 'jpeg') {
                $img =  $request->image;
                $folderPath = "public/users/img/";

                $image_parts = explode(";base64,", $img);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];

                $image_base64 = base64_decode($image_parts[1]);
                $fileName = uniqid() . '.jpeg';

                $file = $folderPath . $fileName;
                Storage::put($file, $image_base64);
                $photo_masuk = $fileName;
            } else {
                $photo_masuk = $request->file;
            }

            $data['opd_id']     = auth()->user()->opd_id;
            $data['user_id']    = auth()->user()->id;
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
            return $this->success($data, 'Anda Berhasil Mengisi Absen Pagi');
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
