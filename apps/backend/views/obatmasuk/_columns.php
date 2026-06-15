<?php
use yii\helpers\Url;

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
        'attribute'=>'kode_transaksi',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'tanggal_masuk',
        'headerOptions' =>['style'=>'text-align:center;'],
        'contentOptions' =>['style'=>'text-align:center;'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'kode_obat',
        'headerOptions' =>['style'=>'text-align:center;'],
        'contentOptions' =>['style'=>'text-align:center;'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Nama Obat',
        'attribute'=>'nama_obat',
        'label' => 'Nama Obat',
        'value' => function($data){
            $a = \common\models\Obat::find()->where(['kode_obat'=>$data->kode_obat])->one();
            return $a['nama_obat'];
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'jumlah_masuk',
        'headerOptions' =>['style'=>'text-align:center;'],
        'contentOptions' =>['style'=>'text-align:center;'],
    ],
    //[
        //'class'=>'\kartik\grid\DataColumn',
        //'attribute'=>'created_user',
    //],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'created_date',
    // ],
    /*
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
    */
];   