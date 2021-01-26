<?php
require_once'functions.php';
 

    /** LOGIN */ 
    if ($mod=='login'){
        $user = esc_field($_POST['user']);
        $pass = esc_field($_POST['pass']);
        
        $row = $db->get_row("SELECT * FROM tb_user WHERE user='$user' AND pass='$pass'");
        if($row){
            $_SESSION['login'] = $row->user;
            redirect_js("index.php");
        } else{
            print_msg("Salah kombinasi username dan password.");
        }          
    }  else if ($mod=='password'){
        $pass1 = $_POST[pass1];
        $pass2 = $_POST[pass2];
        $pass3 = $_POST[pass3];
        
        $row = $db->get_row("SELECT * FROM tb_user WHERE user='$_SESSION[user]' AND pass='$pass1'");        
        
        if($pass1=='' || $pass2=='' || $pass3=='')
            print_msg('Field bertanda * harus diisi.');
        elseif(!$row)
            print_msg('Password lama salah.');
        elseif( $pass2 != $pass3 )
            print_msg('Password baru dan konfirmasi password baru tidak sama.');
        else{        
            $db->query("UPDATE tb_user SET pass='$pass2' WHERE user='$_SESSION[user]'");                    
            print_msg('Password berhasil diubah.', 'success');
        }
    } elseif($act=='logout'){
        unset($_SESSION['login']);
        header("location:index.php?m=login");
    }
           
    /** PAGE */
    elseif($mod=='page_ubah'){
        $judul = $_POST['judul'];
        $isi = $_POST['isi'];
                        
        if($judul=='' || $isi=='' )
            print_msg("Field yang bertanda * tidak boleh kosong!");
        else{
            $db->query("UPDATE tb_page SET judul='$judul', isi='$isi' WHERE nama_page='$_GET[nama]'");                   
            print_msg("Data tersimpan", 'success');
        }
    } 
    
    /** PURA */    
    if($mod=='tempat_tambah'){
        $nama_tempat = $_POST['nama_tempat'];
        $gambar = $_FILES['gambar'];
        $lat = $_POST['lat'];
        $lng = $_POST['lng'];
        $lokasi = $_POST['lokasi'];
        $keterangan = esc_field($_POST['keterangan']);
        
        if($nama_tempat=='' || $gambar['name']=='' || $lat=='' || $lng=='' || $lokasi=='')
            print_msg("Field bertanda * tidak boleh kosong!");
        else{
            $file_name = rand(1000, 9999) . parse_file_name($gambar['name']);
            $img = new SimpleImage($gambar['tmp_name']);
            if($img->get_width()>800)
                $img->fit_to_width(800);
            if($img->get_height()>600);
                $img->fit_to_height(600);
            $img->save('assets/images/tempat/' . $file_name);            
            $img->thumbnail(180, 120);
            $img->save('assets/images/tempat/small_' . $file_name);
            
            $db->query("INSERT INTO tb_tempat (nama_tempat, gambar, lat, lng, lokasi, keterangan) 
                    VALUES ('$nama_tempat', '$file_name', '$lat', '$lng', '$lokasi', '$keterangan')");                       
            redirect_js("index.php?m=tempat");
        }                    
    } else if($mod=='tempat_ubah'){
        $nama_tempat = $_POST['nama_tempat'];
        $gambar = $_FILES['gambar'];
        $lat = $_POST['lat'];
        $lng = $_POST['lng'];
        $lokasi = $_POST['lokasi'];
        $keterangan = esc_field($_POST['keterangan']);
        
        if($nama_tempat=='' || $lat=='' || $lng=='' || $lokasi=='')
            print_msg("Field bertanda * tidak boleh kosong!");
        else{           
            if($gambar['name']!=''){
                hapus_gambar($_GET['ID']);
                                
                $file_name = rand(1000, 9999) . parse_file_name($gambar['name']);
                $img = new SimpleImage($gambar['tmp_name']);
                if($img->get_width()>800)
                    $img->fit_to_width(800);
                if($img->get_height()>600);
                    $img->fit_to_height(600);
                $img->save('assets/images/tempat/' . $file_name);            
                $img->thumbnail(180, 120);
                $img->save('assets/images/tempat/small_' . $file_name);
                
                $sql_gambar = ", gambar='$file_name'";
            }
            $db->query("UPDATE tb_tempat SET nama_tempat='$nama_tempat' $sql_gambar , lat='$lat', lng='$lng', lokasi='$lokasi', keterangan='$keterangan' WHERE id_tempat='$_GET[ID]'");
            redirect_js("index.php?m=tempat");
        }    
    } else if ($act=='tempat_hapus'){
        hapus_gambar($_GET['ID']);
        $db->query("DELETE FROM tb_tempat WHERE id_tempat='$_GET[ID]'");
        header("location:index.php?m=tempat");
    } 
    
    /** GAMBAR */    
    if($mod=='galeri_tambah'){
        $id_tempat = $_POST['id_tempat'];
        $gambar = $_FILES['gambar'];
        $nama_galeri = $_POST['nama_galeri'];
        $ket_galeri = $_POST['ket_galeri'];
        
        if($id_tempat=='' || $gambar[name]=='')
            print_msg("Field bertanda * tidak boleh kosong!");
        else{            
            $file_name = rand(1000, 9999) . parse_file_name($gambar['name']);
            
            $img = new SimpleImage($gambar['tmp_name']);
            if($img->get_width()>800)
                $img->fit_to_width(800);
            if($img->get_height()>600);
                $img->fit_to_height(600);
            $img->save('assets/images/galeri/' . $file_name);
            $img->thumbnail(180, 120);
            $img->save('assets/images/galeri/small_' . $file_name);
            
            $db->query("INSERT INTO tb_galeri (id_tempat, gambar, nama_galeri, ket_galeri) 
                    VALUES('$id_tempat', '$file_name', '$nama_galeri', '$ket_galeri')");                       
            redirect_js("index.php?m=galeri");
        }                    
    } else if($mod=='galeri_ubah'){
        $id_tempat = $_POST['id_tempat'];
        $gambar = $_FILES['gambar'];
        $nama_galeri = $_POST['nama_galeri'];
        $ket_galeri = $_POST['ket_galeri'];
        
        if($id_tempat=='')
            print_msg("Field bertanda * tidak boleh kosong!");
        else{  
            if($gambar[tmp_name]!=''){
                hapus_galeri($_GET['ID']);
                $file_name = rand(1000, 9999) . parse_file_name($gambar['name']);
                $img = new SimpleImage($gambar['tmp_name']);
                if($img->get_width()>800)
                    $img->fit_to_width(800);
                if($img->get_height()>600);
                    $img->fit_to_height(600);
                $img->save('assets/images/galeri/' . $file_name);
                $img->thumbnail(180, 120);
                $img->save('assets/images/galeri/small_' . $file_name);
                $sql_gambar = ", gambar='$file_name'";
            }
            $db->query("UPDATE tb_galeri SET id_tempat='$id_tempat', nama_galeri='$nama_galeri' $sql_gambar, ket_galeri='$ket_galeri' WHERE id_galeri='$_GET[ID]'");
            redirect_js("index.php?m=galeri");
        }    
    } else if ($act=='galeri_hapus'){
        hapus_galeri($_GET['ID']);
        $db->query("DELETE FROM tb_galeri WHERE id_galeri='$_GET[ID]'");
        header("location:index.php?m=galeri");
    }                        

    /** KOSAN */    
    if($mod=='kosan_tambah'){
        $nama_kosan = $_POST['nama_kosan'];
        $lat = $_POST['lat'];
        $lng = $_POST['lng'];
        
        if($nama_kosan=='' || $lat=='' || $lng=='')
            print_msg("Field bertanda * tidak boleh kosong!");
        else{            
            $db->query("INSERT INTO tb_kosan (id_kos, nama_kosan, lat, lng) 
                    VALUES('$id_kos', '$nama_kosan', '$lat', '$lng')");                       
            redirect_js("index.php?m=kosan");
        }                    
    } else if($mod=='kosan_ubah'){
        $nama_kosan = $_POST['nama_kosan'];
        $lat = $_POST['lat'];
        $lng = $_POST['lng'];
        
        if($nama_kosan=='' || $lat=='' || $lng=='')
            print_msg("Field bertanda * tidak boleh kosong!");
        else{  
            
        }     
        $db->query("UPDATE tb_kosan SET nama_kosan='$nama_kosan', lat='$lat', lng='$lng' WHERE id_kos='$_GET[ID]'");
            redirect_js("index.php?m=kosan");

    } else if ($act=='kosan_hapus'){
        $db->query("DELETE FROM tb_kosan WHERE id_kos='$_GET[ID]'");
        header("location:index.php?m=kosan");
    }                        

/** TRANSPORTASI */    
    if($mod=='transportasi_tambah'){
        $jenis_kendaraan = $_POST['jenis_kendaraan'];
        $gambar = $_FILES['gambar'];
        $keterangan = $_POST['keterangan'];
        
        if($jenis_kendaraan==''|| $gambar['name']=='' || $keterangan=='')
            print_msg("Field bertanda * tidak boleh kosong!");
        else{        

             $file_name = rand(1000, 9999) . parse_file_name($gambar['name']);
            
            $img = new SimpleImage($gambar['tmp_name']);
            if($img->get_width()>800)
                $img->fit_to_width(800);
            if($img->get_height()>600);
                $img->fit_to_height(600);
            $img->save('assets/images/galeri/' . $file_name);
            $img->thumbnail(180, 120);
            $img->save('assets/images/galeri/small_' . $file_name);

            $db->query("INSERT INTO tb_transportasi (jenis_kendaraan, gambar, keterangan) 
                    VALUES('$jenis_kendaraan', '$file_name', '$keterangan')");                       
            redirect_js("index.php?m=transportasi");
        }                    
    } else if($mod=='transportasi_ubah'){
        $jenis_kendaraan = $_POST['jenis_kendaraan'];
        $gambar = $_FILES['gambar'];
        $keterangan = $_POST['keterangan'];

        if($jenis_kendaraan=='' || $keterangan=='')
            print_msg("Field bertanda * tidak boleh kosong!");
        else{  
            if($gambar[tmp_name]!=''){
                hapus_transportasi($_GET['ID']);
                $file_name = rand(1000, 9999) . parse_file_name($gambar['name']);
                $img = new SimpleImage($gambar['tmp_name']);
                if($img->get_width()>800)
                    $img->fit_to_width(800);
                if($img->get_height()>600);
                    $img->fit_to_height(600);
                $img->save('assets/images/galeri/' . $file_name);
                $img->thumbnail(180, 120);
                $img->save('assets/images/galeri/small_' . $file_name);
                $sql_gambar = ", gambar='$file_name'";
            
        }     
        $db->query("UPDATE tb_transportasi SET jenis_kendaraan='$jenis_kendaraan' $sql_gambar, keterangan='$keterangan' WHERE id_kendaraan='$_GET[ID]'");
            redirect_js("index.php?m=transportasi");
        }

    } else if($act=='transportasi_hapus'){
        $db->query("DELETE FROM tb_transportasi WHERE id_kendaraan='$_GET[ID]'");
        header("location:index.php?m=transportasi");
    }                        
/** stationary */    
    if($mod=='stationary_tambah'){
        $nama_stationary = $_POST['nama_stationary'];
        $lat = $_POST['lat'];
        $lng = $_POST['lng'];
        
        if($nama_stationary=='' || $lat=='' || $lng=='')
            print_msg("Field bertanda * tidak boleh kosong!");
        else{            
            $db->query("INSERT INTO tb_stationary (id_stationary, nama_stationary, lat, lng) 
                    VALUES('$id_stationary', '$nama_stationary', '$lat', '$lng')");                       
            redirect_js("index.php?m=stationary");
        }                    
    } else if($mod=='stationary_ubah'){
        $nama_stationary = $_POST['nama_stationary'];
        $lat = $_POST['lat'];
        $lng = $_POST['lng'];
        
        if($nama_stationary=='' || $lat=='' || $lng=='')
            print_msg("Field bertanda * tidak boleh kosong!");
        else{  
            
        }     
        $db->query("UPDATE tb_stationary SET nama_stationary='$nama_stationary', lat='$lat', lng='$lng' WHERE id_stationary='$_GET[ID]'");
            redirect_js("index.php?m=stationary");

    } else if ($act=='stationary_hapus'){
        $db->query("DELETE FROM tb_stationary WHERE id_stationary='$_GET[ID]'");
        header("location:index.php?m=stationary");
    }
    /** lokasikreasi */    
    if($mod=='lokasikreasi_tambah'){
        $lokasi_kreasi = $_POST['lokasi_kreasi'];
        
        if($lokasi_kreasi=='')
            print_msg("Field bertanda * tidak boleh kosong!");
        else{            
            $db->query("INSERT INTO tb_lokasikreasi (id_lokasikreasi, lokasi_kreasi) 
                    VALUES('$id_lokasikreasi', '$lokasi_kreasi')");                       
            redirect_js("index.php?m=lokasikreasi");
        }                    
    } else if($mod=='lokasikreasi_ubah'){
        $lokasi_kreasi = $_POST['lokasi_kreasi'];
        
        if($lokasi_kreasi=='')
            print_msg("Field bertanda * tidak boleh kosong!");
        else{  
            
        }     
        $db->query("UPDATE tb_lokasikreasi SET lokasi_kreasi='$lokasi_kreasi' WHERE id_lokasikreasi='$_GET[ID]'");
            redirect_js("index.php?m=lokasikreasi");

    } else if ($act=='lokasikreasi_hapus'){
        $db->query("DELETE FROM tb_lokasikreasi WHERE id_lokasikreasi='$_GET[ID]'");
        header("location:index.php?m=lokasikreasi");
    }