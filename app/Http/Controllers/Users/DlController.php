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


class DlController extends Controller
{
    protected $presensi;
    public function __construct(PresensiService $presensiService)
    {
        $this->presensi = $presensiService;
    }
    
    public function index()
    {
        return view('users.dl.index');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $presensi = $this->presensi->Query()->where('user_id', $user->id)->where('tanggal', date('Y-m-d'))->first();
        if($presensi && $presensi->status == "Dinas Luar (DL)") {
            return $this->error('Anda sudah melakukan presensi dinas luar!'); 
        }

        $data = $request->except('_token');
        $data['status'] = 'Dinas Luar (DL)';

        $file = $request->img;
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

        if ($request->hasFile('spt')) {
            $data['spt'] = $request->file('spt')->store('public/spt');
        }
        
        $data['opd_id']    = $user->opd_id;
        $data['user_id']    = $user->id;
        $data['tanggal']    = date('Y-m-d');
        
        $data['jam_masuk']  = date('H:i:s');
        $data['lat_long_masuk']  = $request->latLong;
        $data['photo_masuk']     = $photo_masuk;
        
        $data['jam_pulang']  = date('H:i:s');
        $data['lat_long_pulang']  = $request->latLong;
        $data['photo_pulang']     = $photo_masuk;
        $data['status_pulang']     = 'DL ' . date('H:i:s');

        if($presensi) {
            try {
                $this->presensi->update($presensi, $data);
            } catch (Throwable $e) {
                saveLogs($e->getMessage() . ' ' . 'presensi pagi', 'error');
                return $this->error($e->getMessage());
            }
        }else {
            try {
                $this->presensi->store($data);
            } catch (Throwable $e) {
                saveLogs($e->getMessage() . ' ' . 'presensi pagi', 'error');
                return $this->error($e->getMessage());
            }
        }
        
        Presensicount();
        Cache::forget('table_dashboard_' . Auth::user()->id);
        Cache::forget('hadir_' . Auth::user()->id);
        return $this->success($data, 'Anda Berhasil Mengisi Presensi Dinas Luar (DL)');
    }
}
