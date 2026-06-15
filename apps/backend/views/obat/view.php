<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Obat */
?>
<div class="obat-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'kode_obat',
            'nama_obat',
            'harga_beli',
            'harga_jual',
            'satuan',
            'stok',
        ],
    ]) ?>

</div>
