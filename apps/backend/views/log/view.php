<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Log */
?>
<div class="log-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            //'user_id',
            'username',
            'nama',
            'level',
            'login',
            'logout',
        ],
    ]) ?>

</div>
