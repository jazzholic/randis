<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */
?>
<div class="user-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'username',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            'name',
            'email:email',
            //'instansi_id',
            //'pegawai_id',
            'level',
            'status',
            //'created_at',
            //'updated_at',
        ],
    ]) ?>

</div>
