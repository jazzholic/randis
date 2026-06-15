<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ObatKeluar */
?>
<div class="obat-keluar-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'kode_transaksi',
            'tanggal_masuk',
            'kode_obat',
            'jumlah_keluar',
            'created_user',
            'created_date',
        ],
    ]) ?>

</div>
