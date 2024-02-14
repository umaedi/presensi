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
                            <div id="x-action" class="row d-none">
                                <div class="col-md-6">
                                    <button class="btn btn-primary btn-lg btn-block mb-3" onclick="absenStore()">Isi Presensi</button>
                                </div>
                                <div class="col-md-6">
                                    <button id="x-resetCamera" class="btn btn-warning btn-lg btn-block">Ganti Photo</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>