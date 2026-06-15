<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\JenisBarang */
?>
<div class="jenis-barang-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_jenis_barang',
            'jenis_barang',
        ],
    ]) ?>

</div>
