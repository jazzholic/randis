<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\RiwayatPajak */
?>
<div class="riwayat-pajak-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id_pajak',
            [
                'attribute'=>'kendaraan_id',
                'value'=>$model['kendaraan']['nopol']
            ],
            'tanggal_bayar',
            'jumlah_bayar',
            'tanggal_expired',
            [
                'attribute'=>'instansi_id',
                'label' => 'Instansi',
                'value'=>$model['instansi']['nama_instansi']
            ],
        ],
    ]) ?>

</div>