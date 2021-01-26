<?php
    $row = $db->get_row("SELECT * FROM tb_transportasi WHERE id_kendaraan='$_GET[ID]'"); 
?>
<div class="page-header">
    <h1>Ubah Kendaraan</h1>
</div>
<div class="row">
    <div class="col-sm-6">
        <?php if($_POST) include'aksi.php'?>
        <form method="post" action="?m=transportasi_ubah&ID=<?=$row->id_kendaraan?>" enctype="multipart/form-data">
            <div class="form-group">
                <label>Jenis Kendaraan</label>
                <input class="form-control" type="text" name="jenis_kendaraan" value="<?=$row->jenis_kendaraan?>"/>
            </div>
            <div class="form-group">
                <label>Gambar</label>
                <input class="form-control" type="file" name="gambar"/>
                <p class="help-block">Kosongkan jika tidak mengubah gambar</p>
                <img class="thumbnail" src="assets/images/galeri/small_<?=$row->gambar?>" height="60" />
            </div>
            <div class="form-group">
                <label>Keterangan</label>
                <input class="form-control" type="text" name="keterangan" value="<?=$row->keterangan?>"/>
            </div>
            <div class="form-group">
                <button class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                <a class="btn btn-danger" href="?m=kendaraan"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
            </div>
        </form>
    </div>
</div>