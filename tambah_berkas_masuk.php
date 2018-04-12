<?php
    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else {

        if(isset($_REQUEST['submit'])){

            //validasi form kosong
            if($_REQUEST['Asal_Surat'] == "" || $_REQUEST['Perihal'] == "" || $_REQUEST['No_Surat'] == "" || $_REQUEST['Tanggal_Surat'] == ""
                || $_REQUEST['Tanggal_Agenda'] == "" || $_REQUEST['No_TU'] == "" || $_REQUEST['Kategori'] == ""  || $_REQUEST['Catatan'] == "" | $_REQUEST['Diteruskan_ke'] == "" | $_REQUEST['Keterangan_'] == ""){
                $_SESSION['errEmpty'] = 'ERROR! Form Bertanda * wajib diisi!';
                echo '<script language="javascript">window.history.back();</script>';
            } else {

                $Asal_Surat = $_REQUEST['Asal_Surat'];
                $Perihal = $_REQUEST['Perihal'];
                $No_Surat = $_REQUEST['No_Surat'];
                $Tanggal_Surat = $_REQUEST['Tanggal_Surat'];
                $Tanggal_Agenda = $_REQUEST['Tanggal_Agenda'];
                $No_TU = $_REQUEST['No_TU'];
                $Kategori = $_REQUEST['Kategori'];
                $Catatan = $_REQUEST['Catatan'];
                $Diteruskan_ke = $_REQUEST['Diteruskan_ke'];
                $id_user = $_SESSION['id_user'];

                //validasi input data
					if(!preg_match("/^[a-zA-Z0-9.,() \/ -]*$/", $Asal_Surat)){
                        $_SESSION['Asal_Surat'] = 'Form Asal Surat hanya boleh mengandung karakter huruf, angka, spasi, titik(.), minus(-) dan garis miring(/)';
                        echo '<script language="javascript">window.history.back();</script>';
                    } else {

                        if(!preg_match("/^[a-zA-Z0-9.,_()%&@;\/\r\n -]*$/", $Perihal)){
                            $_SESSION['Perihal'] = 'Form Perihal Surat hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), kurung(), underscore(_), dan(&) persen(%) dan at(@)';
                            echo '<script language="javascript">window.history.back();</script>';
                        } else {

                            if(!preg_match("/^[a-zA-Z0-9., ]*$/", $No_Surat)){
                                $_SESSION['No_Surat'] = 'Form Nomor Surat hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), kurung(), underscore(_), dan(&) persen(%) dan at(@)';
                                echo '<script language="javascript">window.history.back();</script>';
                            } else {

                                if(!preg_match("/^[0-9.- ]*$/", $Tanggal_Surat)){
                                    $_SESSION['Tanggal_Surat'] = 'Form Tanggal Surat hanya boleh mengandung angka dan minus(-)';
                                    echo '<script language="javascript">window.history.back();</script>';
                                } else {

                                    if(!preg_match("/^[0-9.- ]*$/", $Tanggal_Agenda)){
                                        $_SESSION['Tanggal_Agenda'] = 'Form Tanggal Agenda hanya boleh mengandung angka dan minus(-)';
                                        echo '<script language="javascript">window.history.back();</script>';
                                    } else {

                                        if(!preg_match("/^[a-zA-Z0-9., ]*$/", $No_TU)){
                                            $_SESSION['No_TU'] = 'Form Nomor TU hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), kurung(), underscore(_), dan(&) persen(%) dan at(@)';
                                            echo '<script language="javascript">window.history.back();</script>';
                                        } else {
											
											if(!preg_match("/^[a-zA-Z0-9.,() \/ -]*$/", $Kategori)){
                                            $_SESSION['Kategori'] = 'Form Kategori hanya boleh mengandung karakter huruf, angka, spasi, titik(.), minus(-) dan garis miring(/)';
                                            echo '<script language="javascript">window.history.back();</script>';
											} else {
												
												if(!preg_match("/^[a-zA-Z0-9.,_()%&@;\/\r\n -]*$/", $Catatan)){
												$_SESSION['Catatan'] = 'Form Catatan Surat hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), kurung(), underscore(_), dan(&) persen(%) dan at(@)';
												echo '<script language="javascript">window.history.back();</script>';
												} else {
													
													if(!preg_match("/^[a-zA-Z0-9.,() \/ -]*$/", $Diteruskan_ke)){
													$_SESSION['Diteruskan_ke'] = 'Form Catatan hanya boleh mengandung karakter huruf, angka, spasi, titik(.), minus(-) dan garis miring(/)';
													echo '<script language="javascript">window.history.back();</script>';
													} else {

														if(!preg_match("/^[a-zA-Z0-9.,()\/ -]*$/", $Keterangan_)){
														$_SESSION['Keterangan_'] = 'Form Keterangan hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), dan kurung()';
														echo '<script language="javascript">window.history.back();</script>';
														} else {

                                                $cek = mysqli_query($config, "SELECT * FROM tbl_berkas WHERE No_Surat='$No_Surat'");
                                                $result = mysqli_num_rows($cek);

                                                if($result > 0){
                                                    $_SESSION['errDup'] = 'Nomor Surat sudah terpakai, gunakan yang lain!';
                                                    echo '<script language="javascript">window.history.back();</script>';
                                                } else {

                                                    $ekstensi = array('jpg','png','jpeg','doc','docx','pdf','mp3','mp4','m4a','mkv','wav');
                                                    $File = $_FILES['File']['name'];
                                                    $x = explode('.', $File);
                                                    $eks = strtolower(end($x));
                                                    $ukuran = $_FILES['File']['size'];
                                                    $target_dir = "upload/surat_masuk/";

                                                    //jika form file tidak kosong akan mengeksekusi script dibawah ini
                                                    if($File != ""){

                                                        $rand = rand(1,10000);
                                                        $nfile = $rand."-".$File;

                                                        //validasi file
                                                        if(in_array($eks, $ekstensi) == true){
                                                            if($ukuran < 838860800){

                                                                move_uploaded_file($_FILES['File']['tmp_name'], $target_dir.$nfile);

                                                                $query = mysqli_query($config, "INSERT INTO tbl_berkas(,Asal_Surat,Perihal,No_Surat,Tanggal_Surat,Tanggal_Agenda,No_TU,File,Kategori,Catatan,Diteruskan_ke,nfile,id_user)
                                                                        VALUES('$Asal_Surat','$Perihal','$No_Surat','$Tanggal_Surat','$Tanggal_Agenda','$No_TU','$File','$Kategori','$Catatan','$Diteruskan_ke''$nfile','$id_user')");

                                                                if($query == true){
                                                                    $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                                                                    header("Location: ./admin.php?page=tbm");
                                                                    die();
                                                                } else {
                                                                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                                                    echo '<script language="javascript">window.history.back();</script>';
                                                                }
                                                            } else {
                                                                $_SESSION['errSize'] = 'Ukuran file yang diupload terlalu besar!';
                                                                echo '<script language="javascript">window.history.back();</script>';
                                                            }
                                                        } else {
                                                            $_SESSION['errFormat'] = 'Format file yang diperbolehkan hanya *.JPG, *.PNG, *.DOC, *.DOCX, *.PDF, *.MP3, *.MP4, *.M4A, *.MKV, dan *.WAV!';
                                                            echo '<script language="javascript">window.history.back();</script>';
                                                        }
                                                    } else {

                                                        //jika form file kosong akan mengeksekusi script dibawah ini
                                                        $query = mysqli_query($config, "INSERT INTO tbl_berkas(Asal_Surat,Perihal,No_Surat,Tanggal_Surat,Tanggal_Agenda,No_TU,File,Kategori,Catatan,Diteruskan_ke,nfile,id_user)
                                                            VALUES('$Asal_Surat','$Perihal','$No_Surat','$Tanggal_Surat','$Tanggal_Agenda','$No_TU','$File','$Kategori','$Catatan','$Diteruskan_ke''$nfile','$id_user')");

                                                        if($query == true){
                                                            $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                                                            header("Location: ./admin.php?page=tbm");
                                                            die();
                                                        } else {
                                                            $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                                            echo '<script language="javascript">window.history.back();</script>';
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
         else {?>

            <!-- Row Start -->
            <div class="row">
                <!-- Secondary Nav START -->
                <div class="col s12">
                    <nav class="secondary-nav">
                        <div class="nav-wrapper blue-grey darken-1">
                            <ul class="left">
                                <li class="waves-effect waves-light"><a href="?page=tsm&act=add" class="judul"><i class="material-icons">mail</i> Tambah Data Berkas Masuk</a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
                <!-- Secondary Nav END -->
            </div>
            <!-- Row END -->

            <?php
                if(isset($_SESSION['errQ'])){
                    $errQ = $_SESSION['errQ'];
                    echo '<div id="alert-message" class="row">
                            <div class="col m12">
                                <div class="card red lighten-5">
                                    <div class="card-content notif">
                                        <span class="card-title red-text"><i class="material-icons md-36">clear</i> '.$errQ.'</span>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    unset($_SESSION['errQ']);
                }
                if(isset($_SESSION['errEmpty'])){
                    $errEmpty = $_SESSION['errEmpty'];
                    echo '<div id="alert-message" class="row">
                            <div class="col m12">
                                <div class="card red lighten-5">
                                    <div class="card-content notif">
                                        <span class="card-title red-text"><i class="material-icons md-36">clear</i> '.$errEmpty.'</span>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    unset($_SESSION['errEmpty']);
                }
            ?>

            <!-- Row form Start -->
            <div class="row jarak-form">

                <!-- Form START -->
                <form class="col s12" method="POST" action="?page=tsm&act=add" enctype="multipart/form-data">

                    <!-- Row in form START -->
                    <div class="row">
                        <div class="input-field col s6 tooltipped" data-position="top" data-tooltip="Isi dengan angka">
                            <i class="material-icons prefix md-prefix">looks_one</i>
                            <input id="no_agenda" type="number" class="validate" name="no_agenda">
                                <?php
                                    if(isset($_SESSION['no_agenda'])){
                                        $no_agenda = $_SESSION['no_agenda'];
                                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$no_agenda.'</div>';
                                        unset($_SESSION['no_agenda']);
                                    }
                                ?>
                            <label for="no_agenda">Nomor Agenda</label>
                        </div>
                        <div class="input-field col s6 tooltipped" data-position="top" data-tooltip="Diambil dari data referensi kode klasifikasi">
                            <i class="material-icons prefix md-prefix">bookmark</i>
                            <input id="kode" type="text" class="validate" name="kode" required>
                                <?php
                                    if(isset($_SESSION['kode'])){
                                        $kode = $_SESSION['kode'];
                                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$kode.'</div>';
                                        unset($_SESSION['kode']);
                                    }
                                ?>
                            <label for="kode">Kode Klasifikasi</label>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">place</i>
                            <input id="asal_surat" type="text" class="validate" name="asal_surat" required>
                                <?php
                                    if(isset($_SESSION['asal_surat'])){
                                        $asal_surat = $_SESSION['asal_surat'];
                                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$asal_surat.'</div>';
                                        unset($_SESSION['asal_surat']);
                                    }
                                ?>
                            <label for="asal_surat">Asal Surat</label>
                        </div>
                        <div class="input-field col s6 tooltipped" data-position="top" data-tooltip="Isi dengan huruf atau angka">
                            <i class="material-icons prefix md-prefix">storage</i>
                            <input id="indeks" type="text" class="validate" name="indeks" required>
                                <?php
                                    if(isset($_SESSION['indeks'])){
                                        $indeks = $_SESSION['indeks'];
                                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$indeks.'</div>';
                                        unset($_SESSION['indeks']);
                                    }
                                ?>
                            <label for="indeks">Indeks Berkas</label>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">looks_two</i>
                            <input id="no_surat" type="text" class="validate" name="no_surat" required>
                                <?php
                                    if(isset($_SESSION['no_surat'])){
                                        $no_surat = $_SESSION['no_surat'];
                                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$no_surat.'</div>';
                                        unset($_SESSION['no_surat']);
                                    }
                                    if(isset($_SESSION['errDup'])){
                                        $errDup = $_SESSION['errDup'];
                                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$errDup.'</div>';
                                        unset($_SESSION['errDup']);
                                    }
                                ?>
                            <label for="no_surat">Nomor Surat</label>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">date_range</i>
                            <input id="tgl_surat" type="text" name="tgl_surat" class="datepicker" required>
                                <?php
                                    if(isset($_SESSION['tgl_surat'])){
                                        $tgl_surat = $_SESSION['tgl_surat'];
                                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$tgl_surat.'</div>';
                                        unset($_SESSION['tgl_surat']);
                                    }
                                ?>
                            <label for="tgl_surat">Tanggal Surat</label>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">description</i>
                            <textarea id="isi" class="materialize-textarea validate" name="isi" required></textarea>
                                <?php
                                    if(isset($_SESSION['isi'])){
                                        $isi = $_SESSION['isi'];
                                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$isi.'</div>';
                                        unset($_SESSION['isi']);
                                    }
                                ?>
                            <label for="isi">Isi Ringkas</label>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">featured_play_list</i>
                            <input id="keterangan" type="text" class="validate" name="keterangan" required>
                                <?php
                                    if(isset($_SESSION['keterangan'])){
                                        $keterangan = $_SESSION['keterangan'];
                                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$keterangan.'</div>';
                                        unset($_SESSION['keterangan']);
                                    }
                                ?>
                            <label for="keterangan">Keterangan</label>
                        </div>
                        <div class="input-field col s6">
                            <div class="file-field input-field tooltipped" data-position="top" data-tooltip="Jika tidak ada file/scan gambar surat, biarkan kosong">
                                <div class="btn light-green darken-1">
                                    <span>File</span>
                                    <input type="file" id="file" name="file">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text" placeholder="Upload file/scan gambar surat masuk">
                                        <?php
                                            if(isset($_SESSION['errSize'])){
                                                $errSize = $_SESSION['errSize'];
                                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$errSize.'</div>';
                                                unset($_SESSION['errSize']);
                                            }
                                            if(isset($_SESSION['errFormat'])){
                                                $errFormat = $_SESSION['errFormat'];
                                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$errFormat.'</div>';
                                                unset($_SESSION['errFormat']);
                                            }
                                        ?>
                                    <small class="red-text">*Format file yang diperbolehkan *.JPG, *.PNG, *.DOC, *.DOCX, *.PDF dan ukuran maksimal file 2 MB!</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Row in form END -->

                    <div class="row">
                        <div class="col 6">
                            <button type="submit" name="submit" class="btn-large blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                        </div>
                        <div class="col 6">
                            <a href="?page=tsm" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
                        </div>
                    </div>

                </form>
                <!-- Form END -->

            </div>
            <!-- Row form END -->

<?php
        }
    }
?>
