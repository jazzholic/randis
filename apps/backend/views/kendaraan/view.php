<?php

use yii\widgets\DetailView;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model common\models\Kendaraan */
?>
<div class="kendaraan-view">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab">Data 1</a></li>
            <li><a href="#tab_2" data-toggle="tab">Data 2</a></li>
            <li><a href="#tab_3" data-toggle="tab">Data Gambar</a></li>
            <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1"> 
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'jenis.jenis_barang',
                    'merk.nama_merk',
                    'type.nama_type',
                    [
                        'label'=>'Merk/Type',
                        'value' => $model['merk_type']
                    ],
                    'isi_silinder',
                    'tahun_pembelian',
                    'nomor_rangka',
                    'nomor_mesin',
                    'nomor_polisi',
                    'nomor_bpkb',
                    'keterangan'
                ],
            ]) ?>
            </div>
            <div class="tab-pane" id="tab_2"> 
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [                    
                    [
                        'attribute'=>'pemegang_id',
                        'value' => function($data){
                            $a = \common\models\Pemegang::find()->where(['id_pemegang'=>$data['pemegang_id']])->one();
                            return $a['nama_pemegang'];
                        }
                    ],
                    'kondisi.kondisi',
                    'harga_pembelian',
                    'pagu_perawatan',
                    'instansi.nama_instansi',
                ],
            ]) ?>
            </div>
            <div class="tab-pane" id="tab_3"> 
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [                    
                    [
                        'attribute'=>'tampak_depan',
                        'format'=>'html',
                        'value'=>Html::img('@web/img/kendaraan/f/'.$model->tampak_depan, ['class' => 'pull-center img-responsive img-thumbnail']),
                    ],
                    [
                        'attribute'=>'tampak_belakang',
                        'format'=>'html',
                        'value'=>Html::img('@web/img/kendaraan/b/'.$model->tampak_belakang, ['class' => 'pull-center img-responsive img-thumbnail']),
                    ],
                    [
                        'attribute'=>'tampak_samping_r',
                        'format'=>'html',
                        'value'=>Html::img('@web/img/kendaraan/r/'.$model->tampak_samping_r, ['class' => 'pull-center img-responsive img-thumbnail']),
                    ],
                    [
                        'attribute'=>'tampak_samping_l',
                        'format'=>'html',
                        'value'=>Html::img('@web/img/kendaraan/l/'.$model->tampak_samping_l, ['class' => 'pull-center img-responsive img-thumbnail']),
                    ],
                ],
            ]) ?>
            </div>
        </div>
    </div>
</div>