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
        'attribute'=>'jenis_id',
        'value' => function($data){
            $a = \common\models\JenisBarang::find()->where(['id_jenis_barang'=>$data['jenis_id']])->one();
            return $a['jenis_barang'];
        },
        'filterType' => GridView::FILTER_SELECT2,
        'filter' => ArrayHelper::map(\common\models\JenisBarang::find()->all(), 'id_jenis_barang', 'jenis_barang'),
        'filterWidgetOptions' => [
            'pluginOptions' => ['allowClear' => true,'style'=>'overflow: none; '],
        ],
        'filterInputOptions' => ['placeholder' => 'Jenis Barang ...','style'=>'overflow: none; '],
        'format' => 'raw',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nama_merk',
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'template' => '{update} {delete}',
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