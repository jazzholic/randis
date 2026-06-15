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

if(Yii::$app->user->identity->level !='administrator'){

    $r  = \common\models\Instansi::find()->select(['id_instansi' ])->where(['parent_id'=>$model->instansi])->all();
    $s = [];
    foreach ($r as $key) {
        $s[] = $key['id_instansi'];
    }
}else{
    $s = [];
}

$kondisi = \common\models\Kondisi::find()->all();
?>
<div class="box box-info setting-update">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> <?= Html::encode($this->title) ?></h3>
        <div class="box-tolls pull-right">
            <?php 
            if(isset($model->instansi)){
            ?>
            <?=Html::a('<i class="fa fa-file-excel-o"></i> Export PDF', ['laporan/kondisipdf', 'params'=>$model],['title'=> 'Export Ke PDF','class'=>'btn btn-danger btn-box-tool','target' => '_blank','style'=>'color:#fff'])?>
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
                    'action' => ['laporan/kondisi'],
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
                    <th style="vertical-align:middle;text-align:center" rowspan="2">TOTAL</th>
                    <th style="vertical-align:middle;text-align:center" colspan="<?=count($kondisi)?>">KONDISI</th>
                </tr>
                <tr>
                <?php foreach ($kondisi as $key) {?>
                    <th style="vertical-align:middle;text-align:center"><?=$key['kondisi']?></th>
                <?php }?>
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
                    <td style="text-align:center"><?=count(\common\models\Kendaraan::find()->where(['instansi_id'=>$model->instansi])->orWhere(['in','instansi_id',$s])->andWhere(['type_id'=>$key['type_id']])->all())?></td>

                    <?php foreach ($kondisi as $val) {?>
                    <td style="text-align:center"><?=count(\common\models\Kendaraan::find()->where(['instansi_id'=>$model->instansi])->orWhere(['in','instansi_id',$s])->andWhere(['kondisi_id'=>$val['id_kondisi']])->andWhere(['type_id'=>$key['type_id']])->all())?></th>
                    <?php }?>
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