<div class="page-header">
    <h1>lokasikreasi</h1>
</div>
<div class="panel panel-default">
    <div class="panel-heading">        
        <form class="form-inline">
            <input type="hidden" name="m" value="lokasikreasi" />
            <div class="form-group">
                <input class="form-control" type="text" placeholder="Pencarian. . ." name="q" value="<?=$_GET['q']?>" />                                                                                
            </div>
            <div class="form-group">
                <button class="btn btn-success"><span class="glyphicon glyphicon-refresh"></span> Refresh</button>
            </div>
            <div class="form-group">
                <a class="btn btn-primary" href="?m=lokasikreasi_tambah"><span class="glyphicon glyphicon-plus"></span> Tambah</a>
            </div>
        </form>
    </div>
    <div class="oxa">
        <table class="table table-bordered table-hover table-striped">
        <thead>
            <tr class="nw">
                <th>No</th>
                <th>Nama lokasikreasi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <?php
        $q = esc_field($_GET['q']);
        $pg = new Paging();        
        $limit = 25;
        $offset = $pg->get_offset($limit, $_GET['page']);
        
        $rows = $db->get_results("SELECT * FROM tb_lokasikreasi WHERE lokasi_kreasi LIKE '%$q%' ORDER BY lokasi_kreasi LIMIT $offset, $limit");
        
        $no = $offset;
        
        $jumrec = $db->get_var("SELECT COUNT(*) 
            FROM tb_lokasikreasi WHERE lokasi_kreasi LIKE '%$q%'");
        
        foreach($rows as $row):
        ?>
        <tr>
            <td><?=++$no?></td>
            <td><?=$row->lokasi_kreasi?></td>
            <td class="nw">
                <a class="btn btn-xs btn-warning" href="?m=lokasikreasi_ubah&ID=<?=$row->id_lokasikreasi?>"><span class="glyphicon glyphicon-edit"></span></a>
                <a class="btn btn-xs btn-danger" href="aksi.php?act=lokasikreasi_hapus&ID=<?=$row->id_lokasikreasi?>" onclick="return confirm('Hapus data?')"><span class="glyphicon glyphicon-trash"></span></a>
            </td>
        </tr>
        <?php endforeach;    ?>
        </table>
    </div>
</div>