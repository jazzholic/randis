<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Kondisi */
?>
<div class="kondisi-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_kondisi',
            'kondisi',
        ],
    ]) ?>

</div>
