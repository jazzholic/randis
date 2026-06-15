<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ObatMasuk */
?>
<div class="obat-masuk-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'kode_transaksi',
            'tanggal_masuk',
            'kode_obat',
            'jumlah_masuk',
            //'created_user',
            //'created_date',
        ],
    ]) ?>

</div>
