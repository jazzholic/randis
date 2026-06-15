<?php
use yii\helpers\Url;
use yii\helpers\Html;

return [
    //[
        //'class' => 'kartik\grid\CheckboxColumn',
        //'width' => '20px',
    //],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'username',
    ],
    /*
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'auth_key',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'password_hash',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'password_reset_token',
    ],
    */
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'name',
        'label'=>'Nama Lengkap',
    ],
    //[
        //'class'=>'\kartik\grid\DataColumn',
        //'attribute'=>'email',
    //],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'instansi_id',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'pegawai_id',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'instansi',
        'value'=> function($data){
            $a = \common\models\Instansi::find()->where(['id_instansi'=>$data->instansi])->one();
            return $a['nama_instansi'];
        },
    ],
    //[
        //'class'=>'\kartik\grid\DataColumn',
         //'attribute'=>'level',
    //],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'created_at',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'updated_at',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'template' => '{reset} {view} {delete}',        
        'buttons' => [
            'reset' => function ($url, $model) {
                return Html::a('<button type="button" class="btn btn-warning btn-xs"><i class="fa fa-key"></i></button>', $url, ['role'=>'modal-remote','title'=>'Reset Password', 'data-toggle'=>'tooltip']);
            },
        ],
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