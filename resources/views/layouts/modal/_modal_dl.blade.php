<div class="modal fade modalbox" id="modalSelfi" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Ambil photo selfi Anda</h5><a href="javascript:;" onclick="resetCamera()" data-dismiss="modal">Close</a>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center">
                    <div class="wallet-footer">
                        <div class="col-md-12">
                            <input id="x-src" type="hidden" name="image">
                            <div id="results" class="webcam-capture-body text-center mb-3">
                                <div class="webcam-capture img-fluid">
                                    <div class="x-selfie-img container">
                                        <img class="img-fluid"src="{{ asset('assets') }}/pegawai/img/selfie.png" alt="" load="lazy" width="100%">
                                    </div>
                                </div>
                                    <div class="basic form-button-group transparent">
                                        <button id="x-absent" class="btn btn-primary btn-block btn-lg" onclick="openCamera(0)">
                                            Ambil photo selfi Anda
                                    </button>
                                </div>
                            </div>
                            @include('layouts.pegawai._loading_submit')
                        </div>
                    </div>
                </div>
                <form id="formDl" enctype="multipart/form-data">
                    @csrf
                    <div id="x-action" class="row d-none">
                        <div class="col-md-6">
                            <div class="form-group boxed">
                                <div class="input-wrapper">
                                    <label class="label" for="spt">SPT (Jika ada)</label>
                                    <input type="file" class="form-control" id="spt" name="spt">
                                    <i class="clear-input">
                                        <ion-icon name="close-circle"></ion-icon>
                                    </i>
                                </div>
                            </div>
                            {{-- <div class="form-group boxed">
                                <div class="input-wrapper">
                                    <label class="label" for="jumlah_dl">Jumlah Dinas Luar (Hari)</label>
                                    <input type="number" required class="form-control" id="jumlah_dl" name="jumlah_dl">
                                    <i class="clear-input">
                                        <ion-icon name="close-circle"></ion-icon>
                                    </i>
                                </div>
                            </div> --}}
                            <div class="form-group boxed">
                                <div class="input-wrapper">
                                    <label class="label" for="keterangan">Keterangan</label>
                                    <textarea type="text" class="form-control" id="keterangan" name="keterangan"></textarea>
                                    <i class="clear-input">
                                        <ion-icon name="close-circle"></ion-icon>
                                    </i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mt-2">
                            <button type="submit" class="btn btn-primary btn-lg btn-block mb-3">Isi Presensi</button>
                        </div>
                    </form>
                    <div class="col-md-6">
                        <a href="javascript:void()" id="x-resetCamera" class="btn btn-warning btn-lg btn-block">Ganti Photo</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>