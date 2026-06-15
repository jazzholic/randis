<?php
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

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
            $b = \common\models\JenisBarang::find()->where(['id_jenis_barang'=>$data->jenis_id])->one();
            return $b['jenis_barang'];
        },
        'filter' => Html::activeDropDownList($searchModel, 'jenis_id', ArrayHelper::map(\common\models\JenisBarang::find()->all(), 'id_jenis_barang', 'jenis_barang'),['class'=>'form-control','prompt' => 'Jenis Barang ...',]),
        'format' => 'raw'
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'merk_id',
        'value' => function($data){
            $c = \common\models\Merk::find()->where(['id_merek'=>$data->merk_id])->one();
            return $c['nama_merk'];
        },
        'filter' => Html::activeDropDownList($searchModel, 'merk_id', ArrayHelper::map(\common\models\Merk::find()->where(['jenis_id'=>$searchModel->jenis_id])->all(), 'id_merek', 'nama_merk'),['class'=>'form-control','prompt' => 'Merk ...',]),
        'format' => 'raw'
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'type_id',
        'value' => function($data){
            $d = \common\models\Type::find()->where(['id_type'=>$data->type_id])->one();
            return $d['nama_type'];
        },
        'filter' => Html::activeDropDownList($searchModel, 'type_id', ArrayHelper::map(\common\models\Type::find()->where(['merk_id'=>$searchModel->merk_id])->andWhere(['jenis_id'=>$searchModel->jenis_id])->all(), 'id_type', 'nama_type'),['class'=>'form-control','prompt' => 'Type ...',]),
    ],
    //[
        //'class'=>'\kartik\grid\DataColumn',
        //'attribute'=>'isi_silinder',
    //],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'tahun_pembelian',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'nomor_rangka',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'nomor_mesin',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nomor_polisi',
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'nomor_bpkb',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'pemegang_id',
        'value' => function($data){
            $a = \common\models\Pemegang::find()->where(['id_pemegang'=>$data->pemegang_id])->one();
            return $a['nama_pemegang'];
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'kondisi_id',
        'headerOptions' =>['style'=>'text-align:center;'],
        'contentOptions' =>['style'=>'text-align:center;'],
        'format' => 'raw',
        'value' => function($data){
            if($data->kondisi_id == '1'){
                return '<span class="badge bg-green text-center">Baik</span>';
            }elseif($data->kondisi_id == '1'){
                return '<span class="badge bg-yellow text-center">Baik</span>';
            }else{
                return '<span class="badge bg-red text-center">Baik</span>';
            }
        }
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'harga_pembelian',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'pagu_perawatan',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'tampak_depan',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'tampak_belakang',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'tampak_samping_r',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'tampak_samping_l',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'instansi_id',
    // ],
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