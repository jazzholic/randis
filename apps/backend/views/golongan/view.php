<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Golongan */
?>
<div class="golongan-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'golongan',
            'pangkat',
        ],
    ]) ?>

</div>
