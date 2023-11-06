<?php

namespace App\Http\Controllers\Pegawai;

use Carbon\Carbon;
use App\Models\Absent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;

class AbsenController extends Controller
{
    public function index()
    {
        $data['tanggal'] = Carbon::now()->format('d M Y');
        $data['title']  = 'Absen Pegawai';

        return view('pegawai.absent.index', $data);
    }

    public function store(Request $request)
    {
        if (\request()->ajax()) {
            $pegawai = auth()->guard('pegawai')->user();

            $absent = Absent::where('pegawai_id', $pegawai->id)->latest()->first();

            if ($absent && $absent->tanggal == date('Y-m-d')) {

                if (strtotime(date('H:i:s')) < strtotime('14:30:00')) {
                    return response()->json([
                        'success'   => false,
                        'message'   => 'Mohon Maaf Absen Sore Belum Dibuka!'
                    ], 403);
                }

                if (isset($absent->jam_pulang)) {
                    return response()->json([
                        'success'   => false,
                        'message'   => 'Hari Ini Anda Sudah Mengisi Absen 2X!'
                    ], 403);
                }

                $img = $request->image;
                $folderPath = "public/pegawai/img/";

                $image_parts = explode(";base64,", $img);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];

                $image_base64 = base64_decode($image_parts[1]);
                $fileName = uniqid() . '.jpeg';

                $file = $folderPath . $fileName;
                Storage::put($file, $image_base64);

                //update absent
                $absentUpdate = $absent->where('tanggal', $absent->tanggal);

                try {
                    $absentUpdate->where('pegawai_id', $absent->pegawai_id)->update([
                        'opd_id'  => $pegawai->opd->id,
                        'pegawai_id'   => $pegawai->id,
                        'tanggal'   => date('Y-m-d'),
                        'jam_pulang' => date('H:i:s'),
                        'lat_long_pulang'   => $request->latLong,
                        'photo_pulang'     => $fileName,
                    ]);
                } catch (QueryException $e) {
                    return response()->json([
                        'success'   => false,
                        'message'   => 'Mohon Maaf Absen gagal!'
                    ], 403);
                }

                return response()->json([
                    'success'   => true,
                    'message'   => 'Anda Berhasil Mengisi Absen Sore'
                ]);
            } else {
                $img = $request->image;
                $folderPath = "public/pegawai/img/";

                $image_parts = explode(";base64,", $img);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];

                $image_base64 = base64_decode($image_parts[1]);
                $fileName = uniqid() . '.jpeg';

                $file = $folderPath . $fileName;
                Storage::put($file, $image_base64);

                if (strtotime(date('H:i:s')) > strtotime(env('jam_absen'))) {
                    $jam_masuk = Carbon::parse(date('H:i:s'));
                    $delay = Carbon::parse(date(env('jam_absen')));
                    $telat = date_diff($jam_masuk, $delay);

                    $date = $telat->h ? $telat->h . ':' . $telat->i . ':' . $telat->s : $telat->i . ':' . $telat->s;
                } else {
                    $date = "";
                };

                try {
                    Absent::create([
                        'opd_id'            => $pegawai->opd->id,
                        'pegawai_id'        => $pegawai->id,
                        'tanggal'           => date('Y-m-d'),
                        'jam_masuk'         => date('H:i:s'),
                        'lat_long_masuk'    => $request->latLong,
                        'photo_masuk'       => $fileName,
                        'status'            => $date,
                    ]);
                } catch (QueryException $e) {
                    Storage::delete('public/pegawai/img' . $fileName);

                    return response()->json([
                        'success'   => false,
                        'message'   => 'Internal Server Error!',
                    ], 500);
                }

                return response()->json([
                    'success'   => true,
                    'message'   => 'Anda Berhasil Mengisi Absen Pagi'
                ]);
            }
        }
    }
}
