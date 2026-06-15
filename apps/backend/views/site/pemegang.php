<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use yii\jui\DatePicker;
use yii\grid\GridView;
use common\widgets\Alert;
use kartik\depdrop\DepDrop;
use kartik\widgets\FileInput;

$this->title = 'Sistim Informasi Kendaraan Dinas';
$this->params['breadcrumbs'][] = $this->title;

?>
<?php $form = ActiveForm::begin([
  'options' => ['enctype' => 'multipart/form-data'],
  'layout' => 'horizontal',
  'fieldConfig' => [
    'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{endWrapper}",
    'horizontalCssClasses' => [
      'label' => 'col-sm-3',
      'offset' => 'col-sm-offset-3',
      'wrapper' => 'col-sm-9',
      'error' => '',
      'hint' => '',
    ],
  ],
]);
?>
<div class="row">
  <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="<?= Yii::$app->request->baseUrl ?>/img/nophoto.png" alt="User profile picture">

              <h3 class="profile-username text-center"><?=$pemegang['nama_pemegang']?></h3>

              <p class="text-muted text-center"><?=$pemegang['jabatan']?></p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>NIP</b> <a class="pull-right"><?=$pemegang['nip_pemegang']?></a>
                </li>
                <li class="list-group-item">
                  <b>Pangkat</b> <a class="pull-right"><?=$pemegang['golongan']['pangkat']?></a>
                </li>
                <li class="list-group-item">
                  <b>E-Mail</b> <a class="pull-right"><?=$pemegang['email']?></a>
                </li>
                <li class="list-group-item">
                  <b>No. Telp</b> <a class="pull-right"><?=$pemegang['no_telp']?></a>
                </li>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
  </div>
  <div class="col-md-9">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#settings" data-toggle="tab" aria-expanded="false">Data Kendaraan</a></li>
        <li class=""><a href="<?=Yii::$app->getUrlManager()->createUrl(['users/histori']);?>">Histori Kendaraan</a></li>
        <li class=""><a href="<?=Yii::$app->getUrlManager()->createUrl(['users/pajak']);?>">Pajak Kendaraan</a></li>
        <li class=""><a href="<?=Yii::$app->getUrlManager()->createUrl(['users/perawatan']);?>">Data Perawatan</a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="settings">          
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab">Data 1</a></li>
            <li><a href="#tab_2" data-toggle="tab">Data 2</a></li>
            <li><a href="#tab_3" data-toggle="tab">Data Gambar</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
              <br/>
                <?= $form->field($model, 'jenis_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(\common\models\JenisBarang::find()->all(), 'id_jenis_barang', 'jenis_barang'),
                    'options' => ['placeholder' => 'Jenis Barang ...','id'=>'jenisbarang'],
                        'pluginOptions' => [
                            'allowClear' => false
                        ],
                    ])->label('Jenis');
                ?>

                <?php
                if(isset($model->jenis_id)){
                    $merk = ArrayHelper::map(\common\models\Merk::find()->where(['jenis_id'=>$model->jenis_id])->asArray()->all(), 'id_merek', 'nama_merk');
                }else{
                    $merk = [];
                }
                ?>

                <?= $form->field($model, 'merk_id')->widget(DepDrop::classname(), [
                    'options' => ['id'=>'merk'],
                    'type' => DepDrop::TYPE_SELECT2,
                    'data' =>  $merk,
                    'pluginOptions'=>[
                        'depends'=>['jenisbarang'],
                        'placeholder' => 'Select...',
                        'url' => Url::to(['all/merk'])
                    ]
                ])->label('Merk');?>

                <?php
                if(isset($model->type_id)){
                    $merk = ArrayHelper::map(\common\models\Type::find()->where(['id_type'=>$model->type_id])->asArray()->all(), 'id_type', 'nama_type');
                }else{
                    $merk = [];
                }
                ?>

                <?= $form->field($model, 'type_id')->widget(DepDrop::classname(), [
                    'options' => ['id'=>'type'],
                    'type' => DepDrop::TYPE_SELECT2,
                    'data' =>  $merk,
                    'pluginOptions'=>[
                        'depends'=>['merk'],
                        'placeholder' => 'Select...',
                        'url' => Url::to(['all/type'])
                    ]
                ])->label('Type');?>

                <?= $form->field($model, 'merk_type')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'isi_silinder',['template'=>'{label}{beginWrapper}<div class="input-group">{input}<span class="input-group-addon">CC</span></div>{endWrapper}'])->textInput(['onkeyup'=>'angka(this);']) ?>

                <?= $form->field($model, 'tahun_pembelian')->textInput(['onkeyup'=>'angka(this);']) ?>

                <?= $form->field($model, 'nomor_rangka')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'nomor_mesin')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'nomor_polisi')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'nomor_bpkb')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'keterangan')->textInput(['maxlength' => true]) ?>
                
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="tab_2">
              <br/>
                <?php
                $url        = \yii\helpers\Url::to(['/ajax/pemegang']);
                if(empty($model->pemegang_id)){
                    $pemegang = '';
                }else{
                    if(\common\models\Pemegang::find()->where(['id_pemegang'=>$model->pemegang_id])->count()>0){
                        $pemegang = \common\models\Pemegang::find()->where(['id_pemegang'=>$model->pemegang_id])->one()->nama_pemegang;
                    }else{
                        $pemegang = '';
                    }
                }
                                                                 
                echo $form->field($model, 'pemegang_id')->widget(Select2::classname(), [
                    'initValueText' => $pemegang, // set the initial display text
                    'options' => ['placeholder' => 'Search for a Pemegang ...'],
                    //'disabled' =>true,
                    'pluginOptions' => [
                        //'disabled' => (Yii::$app->user->identity->level === 'administrator' ? false:true),
                        'allowClear' => true,
                        'minimumInputLength' => 3,
                        'language' => [
                            'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                        ],
                        'ajax' => [
                            'url' => $url,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                        'templateResult' => new JsExpression('function(pemegang) { return pemegang.text; }'),
                        'templateSelection' => new JsExpression('function (pemegang) { return pemegang.text; }'),
                    ],
                ]);
                ?>

                <?= $form->field($model, 'kondisi_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(\common\models\Kondisi::find()->all(), 'id_kondisi', 'kondisi'),
                    'options' => ['placeholder' => 'Kondisi Kendaraan ...','id'=>'kondisi'],
                        'pluginOptions' => [
                            'allowClear' => false
                        ],
                    ])->label('Kondisi');
                ?>

                <?= $form->field($model, 'harga_pembelian')->textInput(['maxlength' => true,'onkeyup'=>'angka(this);']) ?>

                <?= $form->field($model, 'pagu_perawatan')->textInput(['maxlength' => true,'onkeyup'=>'angka(this);']) ?>

                <?= $form->field($model, 'instansi_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(\common\models\Instansi::find()->all(), 'id_instansi', 'nama_instansi'),
                    'options' => ['placeholder' => 'Instansi ...','id'=>'instansi'],
                        'pluginOptions' => [
                            'allowClear' => false,
                            'disabled' => (Yii::$app->user->identity->level !='administrator' ? true:false)
                        ],
                    ]);
                ?>
                
            </div>
            <div class="tab-pane" id="tab_3">
              <br/>
                <?= $form->field($model, 'tampak_depan')->widget(FileInput::classname(), [
                    'options' => ['accept' => 'image/*'],
                    'pluginOptions' => [
                        'showRemove' => false,
                        'showUpload' => false,
                        'initialPreview'=> [
                           $model->isNewRecord ? '':Html::img('@web/img/kendaraan/f/'.$model->tampak_depan, ['class' => 'pull-center img-responsive img-thumbnail']),
                        ],
                        'browseLabel' =>  'Pilih Gambar'
                    ],
                ]);
                ?>

                <?= $form->field($model, 'tampak_belakang')->widget(FileInput::classname(), [
                    'options' => ['accept' => 'image/*'],
                    'pluginOptions' => [
                        'showRemove' => false,
                        'showUpload' => false,
                        'initialPreview'=> [
                           $model->isNewRecord ? '':Html::img('@web/img/kendaraan/b/'.$model->tampak_belakang, ['class' => 'pull-center img-responsive img-thumbnail']),
                        ],
                        'browseLabel' =>  'Pilih Gambar'
                    ],
                ]);
                ?>

                <?= $form->field($model, 'tampak_samping_r')->widget(FileInput::classname(), [
                    'options' => ['accept' => 'image/*'],
                    'pluginOptions' => [
                        'showRemove' => false,
                        'showUpload' => false,
                        'initialPreview'=> [
                           $model->isNewRecord ? '':Html::img('@web/img/kendaraan/r/'.$model->tampak_samping_r, ['class' => 'pull-center img-responsive img-thumbnail']),
                        ],
                        'browseLabel' =>  'Pilih Gambar'
                    ],
                ]);
                ?>

                <?= $form->field($model, 'tampak_samping_l')->widget(FileInput::classname(), [
                    'options' => ['accept' => 'image/*'],
                    'pluginOptions' => [
                        'showRemove' => false,
                        'showUpload' => false,
                        'initialPreview'=> [
                           $model->isNewRecord ? '':Html::img('@web/img/kendaraan/l/'.$model->tampak_samping_l, ['class' => 'pull-center img-responsive img-thumbnail']),
                        ],
                        'browseLabel' =>  'Pilih Gambar'
                    ],
                ]);
                ?>  
                
            </div>               
          </div>          
        </div>
      </div>
      <div class="box-footer">
        <?= Html::submitButton('<i class="fa fa-check-square-o" aria-hidden="true"></i> Update', ['class' => 'btn btn-danger pull-right']) ?>
      </div>
    </div>
  </div>
</div>
<?php ActiveForm::end(); ?>
<script type="text/javascript">
    function angka(e) {
        if (!/^[0-9]+$/.test(e.value)) {
            e.value = e.value.substring(0,e.value.length-1);
        }
    }
</script>