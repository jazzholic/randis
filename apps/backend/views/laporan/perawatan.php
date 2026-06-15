<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;


$this->title = 'Laporan Rekap Perawatan dan BBM Kendaraan Dinas';
$this->params['breadcrumbs'][]=['label'=>'Laporan', 'url'=>['index']];
$this->params['breadcrumbs'][]= $this->title;

?>
<div class="box box-info setting-update">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> <?= Html::encode($this->title) ?></h3>
        <div class="box-tolls pull-right">
            <?php 
            if(isset($model->instansi)){
            ?>
            <?=Html::a('<i class="fa fa-file-excel-o"></i> Export PDF', ['laporan/perawatanpdf', 'params'=>$model],['title'=> 'Export Ke PDF','class'=>'btn btn-danger btn-box-tool','target' => '_blank','style'=>'color:#fff'])?>
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
                    'action' => ['laporan/perawatan'],
                    'method' => 'get',
                ]);
                ?>

                <?= $form->field($model, 'instansi')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(\common\models\Instansi::find()->all(), 'id_instansi', 'nama_instansi'),
                    'options' => ['placeholder' => 'Instansi ...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'disabled'=>(Yii::$app->user->identity->level != 'administrator' ? true:false)
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
                    <th style="vertical-align:middle;text-align:center" rowspan="2">#</th>
                    <th style="vertical-align:middle;text-align:left" rowspan="2">JENIS BARANG</th>
                    <th style="vertical-align:middle;text-align:left" rowspan="2">MERK</th>
                    <th style="vertical-align:middle;text-align:left" rowspan="2">TYPE</th>
                    <th style="vertical-align:middle;text-align:center" rowspan="2">TANGGAL</th>
                    <th style="vertical-align:middle;" rowspan="2">REKANAN</th>
                    <th style="vertical-align:middle;" rowspan="2">JENIS BBM</th>
                    <th style="vertical-align:middle;text-align:center" rowspan="2">KETERANGAN</th>
                    <th style="vertical-align:middle;text-align:center" rowspan="2">TOTAL BIAYA</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(isset($_GET['page'])){
                  $i = ((int) $_GET['page'] -1)*20+1;
                }else{
                  $i = 1; 
                }
                foreach ($dataProvider->getModels() as $key) {

                ?>       
                <tr>
                    <td style="text-align:center"><?=$i?></td>
                    <td><?=$key['jenis_barang']?></td>
                    <td><?=$key['nama_merk']?></td>
                    <td><?=$key['nama_type']?></td>
                    <td style="text-align:center"><?=$key['tanggal']?></td>
                    <td><?=$key['rekanan']?></td>
                    <td><?=$key['jenis_bbm']?></td>
                    <td><?=$key['keterangan']?></td>
                    <td style="text-align:right">Rp. <?=number_format($key['total_biaya'],0,',','.')?></td>
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