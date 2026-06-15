<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Histori */
?>
<div class="histori-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            [
                'attribute'=>'kendaraan_id',
                'value'=>$model['kendaraan']['nopol']
            ],
            'nopol_awal',
            'nopol_akhir',
            'nama_pemegang',
            [
                'label'=>'Tanggal Perubahan',
                'value'=>$model['tanggal']
            ],
            [
                'attribute'=>'instansi_id',
                'label' => 'Instansi',
                'value'=>$model['instansi']['nama_instansi']
            ],
            'keterangan'
        ],
    ]) ?>

</div>