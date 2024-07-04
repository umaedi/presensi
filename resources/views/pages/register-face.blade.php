@extends('layouts.pages')
@section('content')
    <div id="appCapsule">
        <div class="section mt-2">
            <h1>
                Tutorial Cara Daftar Wajah untuk Aplikasi Presensi dengan Fitur Face Recognition
            </h1>
            <div class="blog-header-info mt-2 mb-2">
                <div>
                    by <a href="#">Admin</a>
                </div>
                <div>
                    Thu, 4 Jul 2024
                </div>
            </div>
            <div class="lead" style="color: #575757; font-size: 20px;">
               <p>1. Langkah pertama buka aplikasi presensi SIAP TUBA</p>
               <p>2. Klik <span class="font-weight-bold">menu profil</span> di pojok kanan bawah</p>
               <figure>
                    <img src="{{ asset('img/tutorial/gambar4.jpeg') }}" alt="image" class="imaged img-fluid">
                </figure>
                <p>3. Klik <span class="font-weight-bold">photo profil,</span> lihat gambar dibawah ini</p>
                <figure>
                    <img src="{{ asset('img/tutorial/gambar1.jpeg') }}" alt="image" class="imaged img-fluid">
                </figure>
                <p>4. Setelah kamera terbuka silakan klik tombol <span class="font-weight-bold">Ambil photo selfi Anda</span></p>
                <figure>
                    <img src="{{ asset('img/tutorial/gambar2.jpeg') }}" alt="image" class="imaged img-fluid">
                </figure>
                <p>5. Terakhir klik tombol <span class="font-weight-bold">Daftarkan wajah</span></p>
                <figure>
                    <img src="{{ asset('img/tutorial/gambar3.jpeg') }}" alt="image" class="imaged img-fluid">
                </figure>
                <p>6. Jika berhasil maka akan muncul notifikasi popup seperti pada gambar dibawah ini</p>
                <figure>
                    <img src="{{ asset('img/tutorial/gambar5.jpeg') }}" alt="image" class="imaged img-fluid">
                </figure>
                <p>7. Selanjutnya silakan lakukan presensi seperti biasanya</p>
            </div>
        </div>
    </div>
@endsection
