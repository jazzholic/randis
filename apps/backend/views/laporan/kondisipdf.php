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

$kondisi = \common\models\Kondisi::find()->all();

if(Yii::$app->user->identity->level !='administrator'){

    $r  = \common\models\Instansi::find()->select(['id_instansi' ])->where(['parent_id'=>$instansi['id_instansi']])->all();
    $s = [];
    foreach ($r as $key) {
        $s[] = $key['id_instansi'];
    }
}else{
    $s = [];
}

?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Laporan Berdasarkan Kondisi Kendaraan</title>
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
<h3 style="text-align: center;padding-bottom: 5px;">REKAPITULASI MENURUT KONDISI<br><?=$instansi['nama_instansi']?><br>Kondisi : <?=datetimes(date('Y-m-d'))?></h3>
<div class="table">
<table style="border-spacing: 0;border-collapse: collapse; width: 100%;">
            <thead>
                <tr>
                    <th style="vertical-align:middle;text-align:center" rowspan="2">#</th>
                    <th style="vertical-align:middle;text-align:left" rowspan="2">JENIS BARANG</th>
                    <th style="vertical-align:middle;text-align:center" rowspan="2">MERK</th>
                    <th style="vertical-align:middle;text-align:left" rowspan="2">TYPE</th>
                    <th style="vertical-align:middle;text-align:center" rowspan="2">TOTAL</th>
                    <th style="vertical-align:middle;text-align:center" colspan="<?=count($kondisi)?>">KONDISI</th>
                </tr>
                <tr>
                <?php foreach ($kondisi as $key) {?>
                    <th style="vertical-align:middle;text-align:center"><?=$key['kondisi']?></th>
                <?php }?>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1;foreach ($dataProvider->getModels() as $key) {?>       
                <tr>
                    <td style="text-align:center"><?=$i?></td>
                    <td><?=$key['jenis_barang']?></td>
                    <td style="text-align:center"><?=$key['nama_merk']?></td>
                    <td><?=$key['nama_type']?></td>
                    <td style="text-align:center"><?=count(\common\models\Kendaraan::find()->where(['instansi_id'=>$instansi['id_instansi']])->orWhere(['IN','instansi_id',$s])->andWhere(['type_id'=>$key['type_id']])->all())?></td>

                    <?php foreach ($kondisi as $val) {?>
                    <td style="text-align:center"><?=count(\common\models\Kendaraan::find()->where(['instansi_id'=>$instansi['id_instansi']])->orWhere(['IN','instansi_id',$s])->andWhere(['kondisi_id'=>$val['id_kondisi']])->andWhere(['type_id'=>$key['type_id']])->all())?></td>
                    <?php }?>
                </tr>
                <?php $i++;}?>
                <tr>
                    <th style="text-align:center" colspan="4">TOTAL</th>
                    <th style="text-align:center"><?=count(\common\models\Kendaraan::find()->where(['instansi_id'=>$instansi['id_instansi']])->orWhere(['IN','instansi_id',$s])->all())?></th>

                    <?php foreach ($kondisi as $val) {?>
                    <th style="text-align:center"><?=count(\common\models\Kendaraan::find()->where(['instansi_id'=>$instansi['id_instansi']])->orWhere(['IN','instansi_id',$s])->andWhere(['kondisi_id'=>$val['id_kondisi']])->all())?></th>
                    <?php }?>
                </tr>
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