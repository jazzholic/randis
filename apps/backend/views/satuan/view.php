<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Satuan */
?>
<div class="satuan-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'satuan',
        ],
    ]) ?>

</div>
