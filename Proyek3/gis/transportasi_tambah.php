    <div class="page-header">
    <h1>Tambah Transportasi</h1>
</div>
<div class="row">
    <div class="col-sm-6">
        <?php if($_POST) include'aksi.php'?>
        <form method="post" action="?m=transportasi_tambah" enctype="multipart/form-data">
            <div class="form-group">
                <label>Jenis Kendaraan</label>
                <input type="text" class="form-control" name="jenis_kendaraan">
            </div>
            <div class="form-group">
                <label>Gambar <span class="text-danger">*</span></label>
                <input class="form-control" type="file" name="gambar" />
            </div>
            <div class="form-group">
                <label>Keterangan</label>
                <input type="text" class="form-control" name="keterangan">
            </div>
            <div class="form-group">
                <button class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                <a class="btn btn-danger" href="?m=kendaraan"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
            </div>
        </form>
    </div>
</div>

