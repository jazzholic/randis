<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;


$this->title = 'Laporan Data Kendaraan Dinas';
$this->params['breadcrumbs'][]=['label'=>'Laporan', 'url'=>['index']];
$this->params['breadcrumbs'][]= $this->title;

function kemarin($tanggal,$komoditi){
    $query = \common\models\Harga::find()->where(['tanggal'=>$tanggal])->andwhere(['komoditi_id'=>$komoditi])->one();

    if(count($query)>0){
        return $query->harga;
    }else{
        return false;
    }
}


?> 
<div class="box box-info setting-update">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> <?= Html::encode($this->title) ?></h3>
        <div class="box-tolls pull-right">
            <?php 
            if(isset($model->instansi)){
            ?>
            <?=Html::a('<i class="fa fa-file-excel-o"></i> Export PDF', ['laporan/allpdf', 'params'=>$model],['title'=> 'Export Ke PDF','class'=>'btn btn-danger btn-box-tool','target' => '_blank','style'=>'color:#fff'])?>
            <?php }?>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12">

                <?php $form = ActiveForm::begin([
                    'options' => ['enctype' => 'multipart/form-data'],
                    'layout' => 'horizontal',
                    'fieldConfig' => [
                        'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{endWrapper}",
                        'horizontalCssClasses' => [
                            'label' => 'col-sm-4',
                            'offset' => 'col-sm-offset-4',
                            'wrapper' => 'col-sm-8',
                            'error' => '',
                            'hint' => '',
                        ],
                    ],
                    'action' => ['laporan/all'],
                    'method' => 'get',
                ]);
                ?>

                <?php
                $instansiList = ArrayHelper::map(\common\models\Instansi::find()->all(), 'id_instansi', 'nama_instansi');
                if (!Yii::$app->user->isGuest && Yii::$app->user->identity->level === 'administrator') {
                    $instansiList = ['0' => 'SEMUA'] + $instansiList;
                }
                ?>
                <?= $form->field($model, 'instansi')->widget(Select2::classname(), [
                    'data' => $instansiList,
                    'options' => ['placeholder' => 'Instansi ...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'disabled' => Yii::$app->user->isGuest || (Yii::$app->user->identity->level ?? null) !== 'administrator'
                    ],
                ]);
                ?>

                <div class="form-group">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-8">
                        <?= Html::submitButton('<i class="fa fa-check-square-o" aria-hidden="true"></i> Tampilkan', ['class' => 'btn btn-danger']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<div class="box box-danger">
    <?php Pjax::begin(['id' => 'all']) ?>
    <div class="box-body">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th style="vertical-align:middle;text-align:center">#</th>
                    <th style="vertical-align:middle;text-align:left">JENIS BARANG</th>
                    <th style="vertical-align:middle;text-align:left">MERK/TYPE</th>
                    <th style="vertical-align:middle;text-align:left">UKURAN/CC</th>
                    <th style="vertical-align:middle;text-align:center">TAHUN PEMBELIAN</th>
                    <th style="vertical-align:middle;text-align:left">KONDISI</th>
                    <th style="vertical-align:middle;text-align:right">HARGA PEMBELIAN</th>
                    <th style="vertical-align:middle;text-align:center">RANGKA</th>
                    <th style="vertical-align:middle;text-align:center">MESIN</th>
                    <th style="vertical-align:middle;text-align:center">POLISI</th>
                    <th style="vertical-align:middle;text-align:center">BPKB</th>
                    <th style="vertical-align:middle;text-align:left">NAMA PEMEGANG</th>
                    <th style="vertical-align:middle;text-align:left">KETERANGAN</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(isset($_GET['page'])){
                  $i = ((int) $_GET['page'] -1)*10+1;
                }else{
                  $i = 1; 
                }
                foreach ($dataProvider->getModels() as $key) {

                ?>       
                <tr>
                    <td style="width : 3%;text-align:center"><?=$i?></td>
                    <td><?=$key['jenis_barang']?></td>
                    <td><?=$key['nama_merk']?>/<?=$key['nama_type']?></td>
                    <td style="text-align:center"><?=$key['isi_silinder']?></td>
                    <td style="text-align:center"><?=$key['tahun_pembelian']?></td>
                    <td><?= $key['kondisi'] ?? '-' ?></td>
                    <td style="text-align:right">
                        <?= number_format($key['harga_pembelian'], 0, ',', '.') ?>
                    </td>
                    <td><?=$key['nomor_rangka']?></td>
                    <td><?=$key['nomor_mesin']?></td>
                    <td><?=$key['nomor_polisi']?></td>
                    <td><?=$key['nomor_bpkb']?></td>
                    <td><?=$key['nama_pemegang']?></td>
                    <td><?=$key['keterangan'] ?? ''?></td>
                </tr>
                <?php $i++;}?>
            </tbody>
        </table>
    </div>
    <div class="box-footer clearfix">
        <?php
        // display pagination
        echo LinkPager::widget([
                  'pagination' => $dataProvider->pagination,
              ]);
        ?>
    </div>
    <?php Pjax::end() ?>
</div>