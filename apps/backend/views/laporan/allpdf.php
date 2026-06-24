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
            <table border="0" width="100%">
                <tr>
                    <td width="70" style="vertical-align:top;">
                        <img src="<?= Yii::getAlias('@webroot') . '/img/pasaman.png' ?>" width="70" style="margin:0;" />
                    </td>
                    <td style="text-align:center;">
                        <h2 style="font-weight: bold;margin:5px 0;">PEMERINTAH KOTA MATARAM</h2>
                        <h2 style="font-weight: bold;margin:5px 0;"><?= $instansi['nama_instansi'] ?? 'SEMUA INSTANSI' ?></h2>
                        <span style="font-size: 11px">
                            <?= $instansi['alamat'] ?? '' ?><br />Telp. : <?= $instansi['telp'] ?? '' ?> Fax. : <?= $instansi['fax'] ?? '' ?> Email : <?= $instansi['email'] ?? '' ?>
                        </span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="border-top:2px solid #000;padding-top:2px">
            &nbsp;
        </td>
    </tr>
</table>
<h3 style="text-align: center;padding-bottom: 5px;">DATA KENDARAAN DINAS PEMERINTAH KOTA MATARAM<br><?=$instansi['nama_instansi']?><br>TAHUN <?=date('Y')?></h3>
<div class="table">
<table style="border-spacing: 0;border-collapse: collapse; width: 100%;">
            <thead>
                <tr>
                    <th style="vertical-align:middle;text-align:center">#</th>
                    <th style="vertical-align:middle;text-align:center">JENIS BARANG</th>
                    <th style="vertical-align:middle;text-align:center">MERK/TYPE</th>
                    <th style="vertical-align:middle;text-align:center">UKURAN/CC</th>
                    <th style="vertical-align:middle;text-align:center">TAHUN PEMBELIAN</th>
                    <th style="vertical-align:middle;text-align:center">KONDISI</th>
                    <th style="vertical-align:middle;text-align:center">HARGA PEMBELIAN</th>
                    <th style="vertical-align:middle;text-align:center">RANGKA</th>
                    <th style="vertical-align:middle;text-align:center">MESIN</th>
                    <th style="vertical-align:middle;text-align:center">POLISI</th>
                    <th style="vertical-align:middle;text-align:center">BPKB</th>
                    <th style="vertical-align:middle;text-align:center">NAMA PEMEGANG</th>
                    <th style="vertical-align:middle;text-align:center">KETERANGAN</th>
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
                    <td><?=$key['kondisi'] ?? '-'?></td>
                    <td style="text-align:right"><?= number_format($key['harga_pembelian'] ?? 0, 0, ',', '.') ?></td>
                    <td><?=$key['nomor_rangka']?></td>
                    <td><?=$key['nomor_mesin']?></td>
                    <td><?=$key['nomor_polisi']?></td>
                    <td><?=$key['nomor_bpkb']?></td>
                    <td><?=$key['nama_pemegang']?></td>
                    <td><?=$key['keterangan'] ?? ''?></td>
                </tr>
                <?php $i++;}?>
            </tbody>
</table>

</div>
<?php if ((int) $model->instansi !== 0): ?>
<table style="width: 100%;margin-top:75px">
    <tr>
        <td style="width: 25%">&nbsp;</td>
        <td style="width: 25%">&nbsp;</td>
        <td style="width: 25%">&nbsp;</td>
        <td style="width: 25%">Mataram, <?=datetimes(date('Y-m-d'))?></td>
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
        <td style="width: 25%"><u>&nbsp;&nbsp;<?= $pejabat['nama_pejabat'] ?? '' ?>&nbsp;&nbsp;</u></td>
    </tr>
    <tr>
        <td style="width: 25%"></td>
        <td style="width: 25%"></td>
        <td style="width: 25%">&nbsp;</td>
        <td style="width: 25%">NIP. <?= $pejabat['nip_pejabat'] ?? '' ?></td>
    </tr>
</table>
<?php endif; ?>
</body>
</html>