<?php
    $row = $db->get_row("SELECT * FROM tb_kosan WHERE id_kos='$_GET[ID]'"); 
?>
<div class="page-header">
    <h1>Ubah Kosan</h1>
</div>
<div class="row">
    <div class="col-sm-6">
        <?php if($_POST) include'aksi.php'?>
        <form method="post" action="?m=kosan_ubah&ID=<?=$row->id_kos?>" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nama Kosan</label>
                <input class="form-control" type="text" name="nama_kosan" value="<?=$row->nama_kosan?>"/>
            </div>
            <div class="form-group">
                <label>Latitude</label>
                <input class="form-control" type="text" name="lat" value="<?=$row->lat?>"/>
            </div>
            <div class="form-group">
                <label>Longtitude</label>
                <input class="form-control" type="text" name="lng" value="<?=$row->lng?>"/>
            </div>
            <div class="form-group">
                <button class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                <a class="btn btn-danger" href="?m=kosan"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
            </div>
        </form>
    </div>
</div>