<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\RiwayatPajak */
?>
<div class="riwayat-pajak-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_pajak',
            'kendaraan_id',
            'tanggal_bayar',
            'tanggal_expired',
            'instansi_id',
        ],
    ]) ?>

</div>
