<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Perawatan */
?>
<div class="perawatan-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute'=>'kendaraan_id',
                'value'=>$model['kendaraan']['nopol']
            ],
            'tanggal',
            'rekanan',
            'bbm.jenis_bbm',
            'jumlah_liter',
            'jumlah_kilometer',
            'total_biaya',
            'keterangan:ntext',
            'lampiran',
            [
                'attribute'=>'instansi_id',
                'label' => 'Instansi',
                'value'=>$model['instansi']['nama_instansi']
            ],
        ],
    ]) ?>

</div>
