<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Pejabat */
?>
<div class="pejabat-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_jabatan',
            'jenis_jabatan',
            'nama_pejabat',
            'nip_pejabat',
            'instansi_id',
        ],
    ]) ?>

</div>
