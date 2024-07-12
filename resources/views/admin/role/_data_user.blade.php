<div class="card-body">
    <div class="form-group mb-2">
        <label for="nama" class="form-label">Nama</label>
        <input name="nama" type="text" id="nama" class="form-control" value="{{ $user->nama }}" />
    </div>
    <div class="form-group mb-2">
        <label for="nip" class="form-label">NIP</label>
        <input name="nip" type="text" id="nip" class="form-control" value="{{ $user->nip }}" />
    </div>
    <div class="form-group mb-2">
        <label for="organisasi" class="form-label">Organisasi</label>
        <input name="organisasi" type="text" id="organisasi" class="form-control" value="{{ $user->opd->nama_opd }}" />
    </div>                              
</div>
