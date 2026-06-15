<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Instansi */
?>
<div class="instansi-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id_instansi',
            'nama_instansi',
            [
                'label' => 'Parent Instansi',
                'value' => function($data){
                    $instansi = \common\models\Instansi::find()->where(['id_instansi'=>$data->parent_id])->one();
                    return $instansi['nama_instansi'];
                }
            ],            
            'alamat:ntext',
            'telp',
            'fax',
            'email:email',
        ],
    ]) ?>

</div>
