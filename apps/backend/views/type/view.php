<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Type */
?>
<div class="type-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_type',
            'jenis_id',
            'merk_id',
            'nama_type',
        ],
    ]) ?>

</div>
