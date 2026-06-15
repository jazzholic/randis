<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\JenisBbm */
?>
<div class="jenis-bbm-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_bbm',
            'jenis_bbm',
        ],
    ]) ?>

</div>
