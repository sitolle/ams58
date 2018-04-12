<?php
    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<strong>ERROR!</strong> Anda harus login terlebih dahulu.';
        header("Location: ./");
        die();
    } else {

        echo '
        <style type="text/css">
            table {
                background: #fff;
                padding: 5px;
            }
            tr, td {
                border: table-cell;
                border: 1px  solid #444;
            }
            tr,td {
                vertical-align: top!important;
            }
            #right {
                border-right: none !important;
            }
            #left {
                border-left: none !important;
            }
            .isi {
                height: 300px!important;
            }
            .disp {
                text-align: center;
                padding: 1.5rem 0;
                margin-bottom: .5rem;
            }
            .logodisp {
                float: left;
                position: relative;
                width: 110px;
                height: 110px;
                margin: 0 0 0 1rem;
            }
            #lead {
                width: auto;
                position: relative;
                margin: 25px 0 0 75%;
            }
            .lead {
                font-weight: bold;
                text-decoration: underline;
                margin-bottom: -10px;
            }
            .tgh {
                text-align: center;
            }
            #nama {
                font-size: 2.1rem;
                margin-bottom: -1rem;
            }
            #alamat {
                font-size: 16px;
            }
            .up {
                text-transform: uppercase;
                margin: 0;
                line-height: 2.2rem;
                font-size: 1.5rem;
            }
            .status {
                margin: 0;
                font-size: 1.3rem;
                margin-bottom: .5rem;
            }
            #lbr {
                font-size: 20px;
                font-weight: bold;
            }
            .separator {
                border-bottom: 2px solid #616161;
                margin: -1.3rem 0 0.5rem;
            }
            @media print{
                body {
                    font-size: 12px;
                    color: #212121;
                }
                table {
                    width: 100%;
                    font-size: 12px;
                    color: #212121;
                }
                tr, td {
                    border: table-cell;
                    border: 1px  solid #444;
                    padding: 8px!important;

                }
                tr,td {
                    vertical-align: top!important;
                }
                #lbr {
                    font-size: 20px;
                }
                .isi {
                    height: 200px!important;
                }
                .tgh {
                    text-align: center;
                }
                .disp {
                    text-align: center;
                    margin: -.5rem 0;
                }
                .logodisp {
                    float: left;
                    position: relative;
                    width: 80px;
                    height: 80px;
                    margin: .5rem 0 0 .5rem;
                }
                #lead {
                    width: auto;
                    position: relative;
                    margin: 15px 0 0 75%;
                }
                .lead {
                    font-weight: bold;
                    text-decoration: underline;
                    margin-bottom: -10px;
                }
                #nama {
                    font-size: 20px!important;
                    font-weight: bold;
                    text-transform: uppercase;
                    margin: -10px 0 -20px 0;
                }
                .up {
                    font-size: 17px!important;
                    font-weight: normal;
                }
                .status {
                    font-size: 17px!important;
                    font-weight: normal;
                    margin-bottom: -.1rem;
                }
                #alamat {
                    margin-top: -15px;
                    font-size: 13px;
                }
                #lbr {
                    font-size: 17px;
                    font-weight: bold;
                }
                .separator {
                    border-bottom: 2px solid #616161;
                    margin: -1rem 0 1rem;
                }

            }
        </style>

        <body onload="window.print()">

        <!-- Container START -->
        <div class="container">
            <div id="colres">
                <div class="disp">';
                    $query2 = mysqli_query($config, "SELECT institusi, nama, alamat1, alamat2, logo FROM tbl_instansi");
                    list($institusi, $nama, $alamat1, $alamat2, $logo) = mysqli_fetch_array($query2);
                    if(!empty($logo)){
                        echo '<img class="logodisp" src="./upload/'.$logo.'"/>';
                    } else {
                        echo '<img class="logodisp" src="./asset/img/logo.png"/>';
                    }
                    if(!empty($institusi)){
                        echo '<h6 class="up">'.$institusi.'</h6>';
                    } else {
                        echo '<h6 class="up">KEMENTERIAN AGRARIA DAN TATA RUANG/BADAN PERTANAHAN NASIONAL</h6>';
                    }
                    if(!empty($nama)){
                        echo '<h5 class="up" id="nama">'.$nama.'</h5><br/>';
                    } else {
                        echo '<h5 class="up" id="nama">INSPEKTORAT JENDERAL</h5><br/>';
                    }
                    if(!empty($alamat1)){
                        echo '<h6 class="alamat">'.$alamat1.'</h6>';
                    } else {
                        echo '<h6 class="alamat">Jl. H. Agus Salim No. 58, Menteng, Jakarta Pusat-10350</h6>';
                    }
                    if(!empty($alamat2)){
                        echo '<h6 span id="alamat">'.$alamat2.'</h6></span>';
                    } else {
                        echo '<span id="alamat">Telepon : (021)31937072 ; e-mail : irjend.atr@gmail.com ; website : www.atrbpn.go.id</span>';
                    }
                    echo '
                </div>
              <div class="separator"></div>';

                $id_surat= mysqli_real_escape_string($config, $_REQUEST['id_surat']);
				$query = mysqli_query($config, "SELECT * FROM tbl_surat_masuk tbl_disposisi WHERE id_surat='$id_surat' ");
				if(mysqli_num_rows($query) > 0){
                $no = 0;
                while($row = mysqli_fetch_array($query)){
                echo '
                    <table border=1>
						<tr>
						<td>
					<table class="bordered" id="tbl">
                        <tbody>
							<tr>
                                <td class="tgh" id="lbr" colspan="6">LEMBAR DISPOSISI</td>
                            </tr>
                            <tr>
                              <td width="150" id="right2"><strong>Nomor Agenda</strong></td>
                              <td width="241" id="left2"><span style="border-right: none;">: '.$id_surat;
if (date('d')==''){ $a = ''; }
else{ $a = sprintf("%d", $id_surat[0]); }
$b = 'IRJ-900';
$c = array('','I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII');
$d = date('Y');
$id_surat = $a.'/'.$b.'/'.$c[date('n')].'/'.$d;
echo $id_surat;['id_surat'].'</span></td>;
                              <td width="133" id="left2"><strong>Nomor Surat</strong></td>
                              <td width="269" id="left2">: '.$row['no_surat'].'</td>
                            </tr>
                            <tr>
                              <td id="right4"><strong>Asal Surat</strong></td>
                              <td id="left4">: '.$row['asal_surat'].'</td>
                              <td id="left4"><strong>Tanggal Surat</strong></td>
							  ';
								$d = substr($row['tgl_surat'],8,2);
                                $m = substr($row['tgl_surat'],5,2);
                                if($m == "01"){
                                    $nm = "Januari";
                                } elseif($m == "02"){
                                    $nm = "Februari";
                                } elseif($m == "03"){
                                    $nm = "Maret";
                                } elseif($m == "04"){
                                    $nm = "April";
                                } elseif($m == "05"){
                                    $nm = "Mei";
                                } elseif($m == "06"){
                                    $nm = "Juni";
                                } elseif($m == "07"){
                                    $nm = "Juli";
                                } elseif($m == "08"){
                                    $nm = "Agustus";
                                } elseif($m == "09"){
                                    $nm = "September";
                                } elseif($m == "10"){
                                    $nm = "Oktober";
                                } elseif($m == "11"){
                                    $nm = "November";
                                } elseif($m == "12"){
                                    $nm = "Desember";
                                }
								$y = substr($row['tgl_surat'],0,4);

                                
                                echo '
                              <td id="left4">: '.$d." ".$nm." ".$y.'</td>
                            </tr>
                            <tr>
                              <td rowspan="2" id="right5"><strong>Perihal</strong></td>
                              <td rowspan="2" id="left5">: '.$row['isi'].'</td>
                              <td id="left5"><strong>Tanggal Agenda</strong></td>
							  ';
								$d = substr($row['tgl_diterima'],8,2);
                                $m = substr($row['tgl_diterima'],5,2);
                                if($m == "01"){
                                    $nm = "Januari";
                                } elseif($m == "02"){
                                    $nm = "Februari";
                                } elseif($m == "03"){
                                    $nm = "Maret";
                                } elseif($m == "04"){
                                    $nm = "April";
                                } elseif($m == "05"){
                                    $nm = "Mei";
                                } elseif($m == "06"){
                                    $nm = "Juni";
                                } elseif($m == "07"){
                                    $nm = "Juli";
                                } elseif($m == "08"){
                                    $nm = "Agustus";
                                } elseif($m == "09"){
                                    $nm = "September";
                                } elseif($m == "10"){
                                    $nm = "Oktober";
                                } elseif($m == "11"){
                                    $nm = "November";
                                } elseif($m == "12"){
                                    $nm = "Desember";
                                }
								$y = substr($row['tgl_diterima'],0,4);

                                
                                echo '
                              <td id="left4">: '.$d." ".$nm." ".$y.'</td>
                            </tr>
						
                    		<tr>
                              <td height="53" id="left8"><strong>Sifat</strong></td>                             
							  <td id="left8">: '.$row['sifat'].'</td>
                          	</tr>
                            <tr>
                              <td height="500" colspan="4" id="right5"><img src="./asset/img/disposisiku.PNG" width="930" height="500" longdesc="./asset/img/disposisiku.PNG"/></td>
                            </tr>
                            <tr class="isi">
                                <td colspan="3">
                                    <strong>Isi Disposisi :</strong><br/>'.$row['isi_disposisi'].'
                                    <div style="height: 50px;"></div>
                                    <strong>Batas Waktu</strong> : '.$d." ".$nm." ".$y.'<br/>
                                    <strong>Sifat</strong> : '.$row['sifat'].'<br/>
                                    <strong>Catatan</strong> :<br/> '.$row['catatan_arahan'].'
                                    <div style="height: 25px;"></div>
                                </td>
                                <td><strong>Diteruskan Kepada</strong> : <br/>'.$row['tujuan_ke'].'</td>
                            </tr>';
                                }
                            } else {
                                echo '
                                <tr class="isi">
                                    <td colspan="3"><strong>Isi Disposisi :</strong>
                                    </td>
                                    <td><strong>Diteruskan Kepada</strong> : </td>
                                </tr>';
                            }
                        } echo '
                </tbody>
            </table>
			</td>
			</tr>
			</table>
            <div id="lead">
              <p>Inspektur Jenderal,</p>
                <div style="height: 50px;"></div>';
                $query = mysqli_query($config, "SELECT kepsek, nip FROM tbl_instansi");
                list($kepsek,$nip) = mysqli_fetch_array($query);
                if(!empty($kepsek)){
                    echo '<p class="lead">'.$kepsek.'</p>';
                } else {
                    echo '<p class="lead">H. Riza Fachri, S.Kom.</p>';
                }
                if(!empty($nip)){
                    echo '<p>NIP. '.$nip.'</p>';
                } else {
                    echo '<p>NIP. -</p>';
                }
                echo '
</div>
        </div>
        <div class="jarak2"></div>
    </div>
    <!-- Container END -->

    </body>';
?>
