<div class="page-header">
    <h1>Tambah Lokasi Kreasi</h1>
</div>
<div class="row">
    <div class="col-sm-6">
        <?php if($_POST) include'aksi.php'?>
        <form method="post" action="?m=lokasikreasi_tambah" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nama Lokasikreasi</label>
                <input type="text" class="form-control" name="lokasi_kreasi">
            </div>
            <div class="form-group">
                <button class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                <a class="btn btn-danger" href="?m=lokasikreasi"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
            </div>
        </form>
    </div>
</div>