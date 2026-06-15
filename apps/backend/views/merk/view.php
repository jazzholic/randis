<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Merk */
?>
<div class="merk-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id_merek',
            'jenis.jenis_barang',
            'nama_merk',
        ],
    ]) ?>

</div>
