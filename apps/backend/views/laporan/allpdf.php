<?php

function datetimes($tgl,$Jam=false){

    $tanggal   = strtotime($tgl);
    $bln_array = array (
        '01'=>'Januari',
        '02'=>'Februari',
        '03'=>'Maret',
        '04'=>'April',
        '05'=>'Mei',
        '06'=>'Juni',
        '07'=>'Juli',
        '08'=>'Agustus',
        '09'=>'September',
        '10'=>'Oktober',
        '11'=>'November',
        '12'=>'Desember'
    );
    $hari_arr = Array ( 
        '0'=>'Minggu',
        '1'=>'Senin',
        '2'=>'Selasa',
        '3'=>'Rabu',
        '4'=>'Kamis',
        '5'=>'Jum`at',
        '6'=>'Sabtu'
    );
    $hari = @$hari_arr[date('w',$tanggal)];
    $tggl = date('j',$tanggal);
    $bln  = @$bln_array[date('m',$tanggal)];
    $thn  = date('Y',$tanggal);
    $jam  = $Jam ? date ('H:i:s',$tanggal) : '';

    return $tggl.' '.$bln.' '.$thn;        
}

$bln_array = array (
    '01'=>'Januari',
    '02'=>'Februari',
    '03'=>'Maret',
    '04'=>'April',
    '05'=>'Mei',
    '06'=>'Juni',
    '07'=>'Juli',
    '08'=>'Agustus',
    '09'=>'September',
    '10'=>'Oktober',
    '11'=>'November',
    '12'=>'Desember'
);

?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Laporan Data Kendaraan Dinas</title>
        <style type="text/css">
            .table table td, .table table th{border: 1px solid #000;padding:5px 5px;}
        </style>
    </head>
    <body style="font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 12px;">
<table border="0" width="100%" cellspacing="1" cellpadding="0">
    <tr>
        <td align="center" style="vertical-align:top;padding-bottom:15px">
            <div style="position: absolute; left:60px; right: 0; top: 60px; bottom: 0;">
                <img src="<?= Yii::$app->request->baseUrl ?>/img/pasaman.png" 
                     style="margin: 0;" width="70" />
            </div><h2 style="font-weight: bold">PEMERINTAH KOTA MATARAM</h2><h2 style="font-weight: bold"><?=$instansi['nama_instansi']?><br /></h2><span style="font-size: 11px">
        <?=$instansi['alamat']?><br />  Telp. : <?=$instansi['telp']?> Fax. : <?=$instansi['fax']?> Email : <?=$instansi['email']?></span><br /></td>
    </tr>
    <tr>
        <td style="border-top:2px solid #000;border-bottom: 1px solid #000;padding-top:2px"><div></div></td>
    </tr>
</table>
<h3 style="text-align: center;padding-bottom: 5px;">DATA KENDARAAN DINAS PEMERINTAH KOTA MATARAM<br><?=$instansi['nama_instansi']?><br>TAHUN <?=date('Y')?></h3>
<div class="table">
<table style="border-spacing: 0;border-collapse: collapse; width: 100%;">
            <thead>
                <tr>
                    <th style="vertical-align:middle;text-align:center" rowspan="2">#</th>
                    <th style="vertical-align:middle;text-align:left" rowspan="2">JENIS BARANG</th>
                    <th style="vertical-align:middle;text-align:left" rowspan="2">MERK/TYPE</th>
                    <th style="vertical-align:middle;text-align:left" rowspan="2">UKURAN/CC</th>
                    <th style="vertical-align:middle;text-align:center" rowspan="2">TAHUN PEMBELIAN</th>
                    <th style="vertical-align:middle;text-align:center" colspan="4">NOMOR</th>
                    <th style="vertical-align:middle;text-align:left" rowspan="2">NAMA PEMEGANG</th>
                    <th style="vertical-align:middle;text-align:left" rowspan="2">KETERANGAN</th>
                </tr>
                <tr>
                    <th style="vertical-align:middle;text-align:center">RANGKA</th>
                    <th style="vertical-align:middle;text-align:center">MESIN</th>
                    <th style="vertical-align:middle;text-align:center">POLISI</th>
                    <th style="vertical-align:middle;text-align:center">BPKB</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1;foreach ($dataProvider->getModels() as $key) {?>       
                <tr>
                    <td style="text-align:center"><?=$i?></td>
                    <td><?=$key['jenis_barang']?></td>
                    <td><?=$key['nama_merk']?>/<?=$key['nama_type']?></td>
                    <td style="text-align:center"><?=$key['isi_silinder']?></td>
                    <td style="text-align:center"><?=$key['tahun_pembelian']?></td>
                    <td><?=$key['nomor_rangka']?></td>
                    <td><?=$key['nomor_mesin']?></td>
                    <td><?=$key['nomor_polisi']?></td>
                    <td><?=$key['nomor_bpkb']?></td>
                    <td><?=$key['nama_pemegang']?></td>
                    <td></td>
                </tr>
                <?php $i++;}?>
            </tbody>
</table>
<?php
$pejabat = \common\models\Pejabat::find()->where(['instansi_id'=>$instansi['id_instansi']])->andWhere(['jenis_jabatan'=>6])->one();
?>


</div>
<table style="width: 100%;margin-top:75px">
    <tr>
        <td style="width: 25%">&nbsp;</td>
        <td style="width: 25%">&nbsp;</td>
        <td style="width: 25%">&nbsp;</td>
        <td style="width: 25%">Makasar, <?=datetimes(date('Y-m-d'))?></td>
    </tr>
    <tr>
        <td style="width: 25%">&nbsp;</td>
        <td style="width: 25%">&nbsp;</td>
        <td style="width: 25%">&nbsp;</td>
        <td style="width: 25%">Pengurus Barang,</td>
    </tr>
    <tr>
        <td style="width: 25%; height: 100px">&nbsp;</td>
        <td style="width: 25%; height: 100px">&nbsp;</td>
        <td style="width: 25%; height: 100px">&nbsp;</td>
        <td style="width: 25%; height: 100px">&nbsp;</td>
    </tr>
    <tr>
        <td style="width: 25%">&nbsp;</td>
        <td style="width: 25%">&nbsp;</td>
        <td style="width: 25%"></td>
        <td style="width: 25%"><u>&nbsp;&nbsp;<?=$pejabat['nama_pejabat']?>&nbsp;&nbsp;</u></td>
    </tr>
    <tr>
        <td style="width: 25%"></td>
        <td style="width: 25%"></td>
        <td style="width: 25%">&nbsp;</td>
        <td style="width: 25%">NIP. <?=$pejabat['nip_pejabat']?></td>
    </tr>
</table>
</body>
</html>