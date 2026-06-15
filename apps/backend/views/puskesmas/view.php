<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Puskesmas */
?>
<div class="puskesmas-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'kode_puskesmas',
            'nama_puskesmas',
            'alamat',
            'no_telp',
            'jenis_puskesmas',
            'status_poned',
        ],
    ]) ?>

</div>
