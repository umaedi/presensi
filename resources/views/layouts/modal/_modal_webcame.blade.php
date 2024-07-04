<div class="modal fade modalbox" id="modalWebcame" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Ambil photo selfi Anda</h5><a href="javascript:;" onclick="resetCamera()" data-dismiss="modal">Close</a>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center">
                    <div class="wallet-footer">
                        <div class="col-md-12">
                            <div id="webcameResult" class="webcam-capture-body text-center mb-3">
                                <div class="xwebcam-capture img-fluid">
                                    <div class="x-selfie-img container">
                                        <img class="img-fluid"src="{{ asset('assets') }}/pegawai/img/selfie.png" alt="" load="lazy" width="100%">
                                    </div>
                                </div>
                                    <div class="basic form-button-group transparent">
                                        <button  class="btn btn-primary btn-block btn-lg" onclick="captureFace()">
                                            Ambil photo selfi Anda
                                    </button>
                                </div>
                            </div>
                            @include('layouts.pegawai._loading_submit')
                            <div id="registerFace" class="row d-none">
                                <div class="col-md-6">
                                    <button id="faceRegister" class="btn btn-primary btn-lg btn-block d-none mb-3" type="button" disabled>
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                         Mendaftarkan Wajah...
                                      </button>
                                      <form id="formRegisterFace">
                                          <button id="btnRegisterface" type="submit" class="btn btn-primary btn-lg btn-block mb-3">Daftarkan Wajah</button>
                                      </form>
                                </div>
                                <div class="col-md-6">
                                    <button id="changeImage" class="btn btn-warning btn-lg btn-block">Ganti Photo</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>