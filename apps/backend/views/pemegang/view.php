<?php

use yii\widgets\DetailView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Pemegang */
?>
<div class="pemegang-view">
<div class="row">    
    <div class="col-md-8">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id_pemegang',
            'nama_pemegang',
            'nip_pemegang',
            [
                'label'=>'Golongan/Pangkat',
                'value'=> $model['golongan']['golpang'],
            ],
            'jenis_kelamin',
            'email:email',
            'jabatan',
            'alamat:ntext',
            'no_telp',
            'instansi.nama_instansi',
        ],
    ]) ?>
    </div>
    <div class="col-md-4">
        <?= Html::img('@web/img/pemegang/'.(!empty($model['namafile']) ? $model['namafile']:'nophoto.png'), ['class' => 'pull-center img-responsive img-thumbnail']); ?>
    </div>
</div>
</div>