<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Session */
?>
<div class="session-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'expire',
            'data',
        ],
    ]) ?>

</div>
