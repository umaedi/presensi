<?php

namespace App\Http\Controllers\Users;

use Throwable;
use App\Jobs\PresensiJob;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Services\PresensiService;
use App\Http\Controllers\Controller;
use App\Jobs\PresensiupdateJob;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
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
        //cek device
        $user = Auth::user();
        $presensi = $this->presensi->Query()->where('user_id', $user->id)->latest()->first();

        if ($presensi && $presensi->tanggal == date('Y-m-d')) {

            if (isset($presensi->jam_pulang)) {
                return $this->error('Hari Ini Anda Sudah Mengisi Presensi 2X!');
            }

            $currentTime = Carbon::now();
            $jamMulai = Carbon::createFromTime(14, 0, 0); // Jam 14 pagi
            $jamSelesai = Carbon::createFromTime(18, 0, 0); // Jam 16 siang

            if (!$currentTime->between($jamMulai, $jamSelesai)) {
                return $this->error('Presensi sore dimulai dari jam 14.00 sampai jam 18.00 sore!');
            }

            $presensiUpdate = $presensi->where('tanggal', $presensi->tanggal)->where('user_id', $user->id)->first();
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

            $hari = $currentTime->format('l');
            if ($hari === 'Friday') {
                $waktuPulang =  Carbon::createFromTime(16, 30, 0);
            } else {
                $waktuPulang = Carbon::createFromTime(16, 00, 0);
            }
            // Membuat objek Carbon untuk pukul 15:30:00
            $batasWaktu = $waktuPulang;

            // Memeriksa apakah waktu saat ini lebih kecil dari $batasWaktu
            if ($currentTime->lessThan($batasWaktu)) {
                // Kondisi jika waktu saat ini lebih kecil dari 15:30:00

                if(Auth::user()->opd_id == '20') {
                    //hitung tpp
                    $tpp_pegawai = Auth::user()->tpp;
                    $tpp_akhir = Auth::user()->tpp_akhir;

                    if ($tpp_pegawai !== '0') {
                        // Mendapatkan total keterlambatan dalam menit
                        $pulangLebihhAwal = $currentTime->diffInMinutes($batasWaktu);
                        
                        // Menghitung potongan berdasarkan rentang keterlambatan
                        if ($pulangLebihhAwal >= 1 && $pulangLebihhAwal <= 30) {
                            $potongan_tpp = 0.5 /100 * $tpp_pegawai; // 0.50% potongan
                        } elseif ($pulangLebihhAwal >= 31 && $pulangLebihhAwal <= 60) {
                            $potongan_tpp = 1 / 100 * $tpp_pegawai; // 1% potongan
                        } elseif ($pulangLebihhAwal >= 61 && $pulangLebihhAwal <= 90) {
                            $potongan_tpp = 1.25 / 100 * $tpp_pegawai; // 1.25% potongan
                        } elseif ($pulangLebihhAwal >= 91 && $pulangLebihhAwal <= 120) {
                            $potongan_tpp = 1.5 / 100 * $tpp_pegawai; // 1.50% potongan
                        }else {
                            $potongan_tpp = 0;
                        }

                        if($tpp_akhir > 0) {
                            $tpp_hasil_pengurangan = $tpp_akhir - $potongan_tpp;
                        }else {
                            $tpp_hasil_pengurangan = $tpp_pegawai - $potongan_tpp;
                        }
                    }
                    $statusPulang = 'Lebih awal ' . date('H:i:s');

                }else {
                    $tpp_hasil_pengurangan = Auth::user()->tpp;
                    $statusPulang = 'Lebih awal ' . date('H:i:s');
                    if(Auth::user()->opd_id == '20') {
                        $tpp_akhir = Auth::user()->tpp_akhir;
                        if($tpp_akhir > 0) {
                            $tpp_hasil_pengurangan = $tpp_akhir;
                        }else {
                            $tpp_hasil_pengurangan = Auth::user()->tpp;
                        }
                    }else {
                        $tpp_hasil_pengurangan = Auth::user()->tpp;
                    }
                }
                
            } else {
                // Kondisi jika waktu saat ini sama atau lebih besar dari 15:30:00
                $statusPulang = 'Tepat waktu';

                if(Auth::user()->opd_id == '20') {
                    $tpp_akhir = Auth::user()->tpp_akhir;
                    if($tpp_akhir > 0) {
                        $tpp_hasil_pengurangan = $tpp_akhir;
                    }else {
                        $tpp_hasil_pengurangan = Auth::user()->tpp;
                    }
                }else {
                    $tpp_hasil_pengurangan = Auth::user()->tpp;
                }
            }

            $data['opd_id']     = $user->opd_id;
            $data['user_id']    = $user->id;
            $data['tanggal']    = date('Y-m-d');
            $data['jam_pulang']  = date('H:i:s');
            $data['lat_long_pulang']  = $request->latLong;
            $data['photo_pulang']     = $photo_pulang;
            $data['status_pulang']     = $statusPulang;

            //update tpp
            $user->update(['tpp_akhir' => $tpp_hasil_pengurangan]);

            try {
                // dispatch(new PresensiupdateJob($presensiUpdate, $data));
                $this->presensi->update($presensiUpdate, $data);
            } catch (Throwable $e) {
                saveLogs($e->getMessage() . ' ' . 'presensi sore', 'error');
                return $this->error($e->getMessage());
            }
            return $this->success('presensi_sore', 'Anda Berhasil Mengisi Presensi Sore');
        } else {
            $currentTime = Carbon::now();
            $jamMasuk = Carbon::parse(env('JAM_MASUK'));

            $jamMulai = Carbon::createFromTime(6, 0, 0); // Jam 6 pagi
            $jamSelesai = Carbon::createFromTime(12, 0, 0); // Jam 12 siang

            if (!$currentTime->between($jamMulai, $jamSelesai)) {
                return $this->error('Presensi pagi dimulai dari jam 6.00 sampai jam 12.00 Siang!');
            }

            if ($currentTime > $jamMasuk) {
                $telat = $currentTime->diff($jamMasuk);

            if(Auth::user()->opd_id == '20') {
                //hitung tpp
                $tpp_pegawai = Auth::user()->tpp;
                $tpp_akhir = Auth::user()->tpp_akhir;
                if ($tpp_pegawai !== '0') {
                    // Mendapatkan total keterlambatan dalam menit
                    $terlambat = Carbon::createFromTimeString(env('JAM_MASUK'));
                    $total_terlambat = $currentTime->diffInMinutes($terlambat);

                    // Menghitung potongan berdasarkan rentang keterlambatan
                    if ($total_terlambat >= 1 && $total_terlambat <= 30) {
                        $potongan_tpp = 0.5 / 100 * $tpp_pegawai; // 0.50% potongan
                    } elseif ($total_terlambat >= 31 && $total_terlambat <= 60) {
                        $potongan_tpp = 1 / 100 * $tpp_pegawai; // 1% potongan
                    } elseif ($total_terlambat >= 61 && $total_terlambat <= 90) {
                        $potongan_tpp = 1.25 / 100 * $tpp_pegawai; // 1.25% potongan
                    } elseif ($total_terlambat >= 91 && $total_terlambat <= 120) {
                        $potongan_tpp = 1.5 / 100 * $tpp_pegawai; // 1.50% potongan
                    }else {
                        $potongan_tpp = 1.5 / 100 * $tpp_pegawai;
                    }
                    // Kurangi total potongan dari TPP untuk mendapatkan TPP akhir setelah potongan
                    if($tpp_akhir > 0) {
                        $tpp_hasil_pengurangan = $tpp_akhir - $potongan_tpp;
                    }else {
                        $tpp_hasil_pengurangan = $tpp_pegawai - $potongan_tpp;
                    }

                }else {
                    $tpp_hasil_pengurangan = '0';
                }
                
            }else {
                $tpp_hasil_pengurangan = Auth::user()->tpp;
            }

            $status = 'Terlambat ' . $telat->format('%H:%I:%S');
            } else {
                $status = 'Tepat waktu';
                $tpp_hasil_pengurangan = Auth::user()->tpp;
            }

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
            
            //update tpp
            $user->update(['tpp_akhir' => $tpp_hasil_pengurangan]);

            try {
                // dispatch(new PresensiJob($data));
                $this->presensi->store($data);
            } catch (Throwable $e) {
                saveLogs($e->getPrevious()->getMessage() . ' ' . 'presensi pagi', 'error');
                return $this->error($e->getMessage());
            }

            //hitung jumlah user
            Presensicount();

            //clear cache
            Cache::forget('table_dashboard_' . Auth::user()->id);
            Cache::forget('hadir_' . Auth::user()->id);
            $data = [
                'presensi_pagi' => true,
                'perangkatId'   => $user->id
            ];
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
        $filePath = storage_path('app/public/users/img/') . $request->file;

        if (file_exists($filePath)) {
            unlink($filePath);
            return $this->success('ok', 'photo berhasil dihapus');
        } else {
            return $this->error('not_found', 'photo tidak ditemukan');
        }
    }
}
