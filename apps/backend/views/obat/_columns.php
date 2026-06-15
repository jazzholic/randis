<?php
use yii\helpers\Url;

function rupiah($angka){
  $rupiah = number_format($angka,0,',','.');
  return $rupiah;
}

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
        [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'kode_obat',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nama_obat',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'contentOptions' =>['style'=>'text-align:right;'],
        'attribute'=>'harga_beli',
        'value' => function($data){
            return 'Rp. '.rupiah($data->harga_beli);
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'contentOptions' =>['style'=>'text-align:right;'],
        'attribute'=>'harga_jual',
        'value' => function($data){
            return 'Rp. '.rupiah($data->harga_jual);
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'satuan',
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'stok',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'created_user',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'created_date',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'updated_user',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'updated_date',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'], 
    ],

];   