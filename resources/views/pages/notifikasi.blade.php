@extends('layouts.pages')
@section('content')
    <div id="appCapsule">
        <div class="section mt-2">
            <h1>
                Pemberitahuan
            </h1>
            <div class="blog-header-info mt-2 mb-2">
                <div>
                    by <a href="#">Admin</a>
                </div>
                <div>
                    26, September 2024
                </div>
            </div>
            <div class="lead" style="color: #575757">
                Assalamu'alaikum Bapak / Ibu pengguna Aplikasi SIAP TUBA.<br/><br/>
                Alhamdulillah semenjak diluncurkan versi uji coba pada 1 Februari 2024, sudah 3053 pegawai Pemerintah Kabupaten Tulang Bawang menggunakan aplikasi ini.<br/><br/>
                Namun kami sadari bahwa aplikasi ini belum sempurna, terutama kesulitan Bapak / Ibu sekalian untuk menempatkan posisi GPS yang akurat. <br/><br/>
                Data kami menunjukkan bahwa lebih dari 25% pengguna masih sering tidak menggunakan titik kordinat yang tepat saat mengisi presensi. Sebagai contoh, misalkan saja ada salah satu pengguna pada saat sebenarnya yang bersangkutan (sengaja atau tidak sengaja) berada di luar jangkauan zonasi Dinas / Badan X, tetapi dapat melakukan presensi tercatat pada radius titik hadir di kantor Dinas / Badan X tersebut.<br/><br/>
                Dengan demikian bahwa lebih dari 25% pengguna tersebut dalam sistem tercatat terindikasi menggunakan aplikasi tambahan fake GPS atau GPS palsu. <br/><br/>
                Untuk itu, agar mengurangi tuduhan indikasi kecurangan penggunaan aplikasi, maka kami akan membantu Bapak / Ibu sekalian dengan diluncurkan Aplikasi SIAP TUBA versi berikutnya yang berbasis Android. <br/><br/>
                Aplikasi versi sebelumnya dalam waktu dekat akan kami tutup. Silakan unduh dan install Aplikasi SIAP TUBA terbaru di PlayStore.
                <br/>
                <br/>
                <span class="font-italic">"Makan es batu, asalkan bukan salju. 
                    Menggunakan GPS palsu, bukan untuk ditiru.
                </span>
                <br/>
                <br/>
                Terima kasih. Sepenuh hati dan cinta, untuk Tulang Bawang. 
                Kami bahagia berbagi kemudahan dan kejujuran. 
                Salam Udang Manis".
                (AaNW)
                
                
            </div>
                <a href="https://play.google.com/store/apps/details?id=com.tulangbawangkab.siaptuba" class="btn btn-primary my-2">Download aplikasi di google play store</a>
                {{-- <a href="/user/dashboard" class="btn btn-danger">Presensi disini</a> --}}
        </div>
    </div>
@endsection
