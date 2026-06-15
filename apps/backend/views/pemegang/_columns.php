<?php
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\grid\GridView;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
        'headerOptions' =>['style'=>'text-align:center;'],
        'contentOptions' =>['style'=>'text-align:center;'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nama_pemegang',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nip_pemegang',
    ],
    /*
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'golongan_id',
        'value' => function($data){
            $a = \common\models\Golongan::find()->where(['id'=>$data->golongan_id])->one();
            return $a['golongan'].' - '.$a['pangkat'];
        }
    ],
    */
    //[
        //'class'=>'\kartik\grid\DataColumn',
        //'attribute'=>'jenis_kelamin',
    //],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'email',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'jabatan',
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'alamat',
    // ],
    /*
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'no_telp',
    ],
    */
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'instansi_id',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'namafile',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'instansi_id',
        'value' => function($data){            
            return $data['instansi']['nama_instansi'];
        },
        'filterType' => GridView::FILTER_SELECT2,
        'filter' => ArrayHelper::map(\common\models\Instansi::find()->all(), 'id_instansi', 'nama_instansi'),
        'filterWidgetOptions' => [
            'pluginOptions' => ['allowClear' => true],
            'disabled' => (Yii::$app->user->identity->level !='administrator' ? true:false)
        ],
        'filterInputOptions' => ['placeholder' => 'Instansi ...'],
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'template' => '{view} {update} {delete}',
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>[
            'role'=>'modal-remote','title'=>'Delete', 
            'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
            'data-request-method'=>'post',
            'data-toggle'=>'tooltip',
            'data-confirm-title'=>'Are you sure?',
            'data-confirm-message'=>'Are you sure want to delete this item'
        ], 
    ],

];   