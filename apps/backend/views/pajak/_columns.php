<?php
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;

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
        'attribute'=>'kendaraan_id',
        'value' => function($data){
            return $data['kendaraan']['kendaraan'];
        },
        'filterType' => GridView::FILTER_SELECT2,
        'filter' => ArrayHelper::map(\common\models\Kendaraan::find()->where(['instansi_id'=>Yii::$app->user->identity->instansi])->all(), 'id_kendaraan', 'kendaraan'),
        'filterWidgetOptions' => [
            'pluginOptions' => ['allowClear' => true],
            //'disabled' => (Yii::$app->user->identity->level !='administrator' ? true:false)
        ],
        'filterInputOptions' => ['placeholder' => 'Kendaraan ...'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'jumlah_bayar',
        'value' => function($data){
            return 'Rp. '.number_format($data['jumlah_bayar'], 0, ',', '.');
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'tanggal_expired',
    ],
    //[
        //'class'=>'\kartik\grid\DataColumn',
        //'attribute'=>'instansi_id',
    //],
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