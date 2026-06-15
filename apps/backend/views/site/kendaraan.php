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

$this->title = 'Sistim Informasi Kendaraan Dinas';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="col-md-4 col-md-offset-4 text-center">
  <h3 style="color:#fff">SISTIM INFORMASI<br/>KENDARAAN DINAS</h3>
  <h5 style="color:#fff">PEMERINTAH KOTA MATARAM</h5>
  <p>&nbsp;</p>
  <p><span class="logo"><img src="<?= Yii::$app->request->baseUrl ?>/img/logo.png"></span></p>
</div>
<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <?= Alert::widget(['id' => 'keterangan',]) ?>
    <div class="panel panel-default">
      <div class="panel-heading">Pencarian Kendaraan</div>
        <div class="panel-body">
          <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data'],
            'fieldConfig' => [
              'template' => "{beginWrapper}\n{input}\n{hint}\n{endWrapper}",
              'horizontalCssClasses' => [
                'label' => 'col-sm-4',
                'offset' => 'col-sm-offset-4',
                'wrapper' => 'col-sm-8',
                'error' => '',
                'hint' => '',
              ],
            ],
            'method' => 'post',
            'action' => ['index'],
          ]);
          ?>
          <div class="col-sm-10 col-xs-12" style="padding-top: 2px;padding-bottom: 2px">
          <?php

            $url        = \yii\helpers\Url::to(['/ajax/all']);

            if(empty($_POST['id'])){
              $kendaraan = '';
            }else{
              $id = (int)$_POST['id'];
              $a  = \common\models\Kendaraan::find()->where(['id_kendaraan'=>$id])->one();
              //if(count($a)>0){
                $kendaraan = $a['nomor_polisi'];
              //}else{
                //$kendaraan = '';
              //}
            }
                                                                                 
            echo Select2::widget([
              'initValueText' => $kendaraan, // set the initial display text
              'name' => 'id',
              'options' => ['placeholder' => 'Nomor Polisi ...'],
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
                'templateResult' => new JsExpression('function(kendaraan) { return kendaraan.text; }'),
                'templateSelection' => new JsExpression('function (kendaraan) { return kendaraan.text; }'),
              ],
            ]);
            ?>
          </div>
          <div class="col-md-2 col-xs-12" style="padding-top: 2px;padding-bottom: 2px">
            <?= Html::submitButton('<i class="fa  fa-search" aria-hidden="true"></i> Search', ['class' => 'btn btn-danger']) ?>
          </div>
          <?php ActiveForm::end(); ?> 
        </div>
    </div>
  </div>
</div>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
      <?php 
      if(isset($_POST['id'])){
        $id = (int)$_POST['id'];
        $model = \common\models\Kendaraan::find()->where(['id_kendaraan'=>$id])->one();
        $histori = \common\models\Histori::find()->where(['kendaraan_id'=>$id])->all();
      ?>
        <?php if(count((array)$model)>0){?>
          <div class="panel panel-default">
              <div class="panel-heading">Data Kendaraan : <b><?=$model['nomor_polisi']?></b></div>

              <div class="panel-body">
                <table class="table table-hover table-bordered">
                  <tr>
                    <th>Nama OPD</th>
                    <td><?=$model['instansi']['nama_instansi']?></td>
                  </tr>
                  <tr>
                    <th>Pemegang Terakhir</th>
                    <td><?=$model['pemegang']['nama_pemegang']?></td>
                  </tr>
                  <tr>
                    <th>Jabatan</th>
                    <td><?=$model['pemegang']['jabatan']?></td>
                  </tr>
                  <tr>
                    <th>Merk</th>
                    <td><?=$model['merk']['nama_merk']?></td>
                  </tr>
                  <tr>
                    <th>Type</th>
                    <td><?=$model['type']['nama_type']?></td>
                  </tr>
                  <tr>
                    <th>Isi Silinder</th>
                    <td><?=$model['isi_silinder']?> CC</td>
                  </tr>
                  <tr>
                    <th>Tahun Pembelian</th>
                    <td><?=$model['tahun_pembelian']?></td>
                  </tr>
                  <tr>
                    <th>Kondisi</th>
                    <td><?=$model['kondisi']['kondisi']?></td>
                  </tr>
                </table>
              </div>
          </div>
          <?php if(!empty($model['tampak_depan']) OR !empty($model['tampak_belakang']) OR !empty($model['tampak_samping_r']) OR !empty($model['tampak_samping_l'])){?>
          <div class="panel panel-default">
              <div class="panel-heading">Photo Kendaraan</b></div>
              <div class="panel-body">
                <div class="owl-carousel">
                  <?php if(!empty($model['tampak_depan'])){?>
                  <div><img src="<?= Yii::$app->request->baseUrl ?>/img/kendaraan/f/<?=$model['tampak_depan']?>"></div>
                  <?php }?>
                  <?php if(!empty($model['tampak_belakang'])){?>
                  <div><img src="<?= Yii::$app->request->baseUrl ?>/img/kendaraan/b/<?=$model['tampak_belakang']?>"></div>
                  <?php }?>
                  <?php if(!empty($model['tampak_samping_r'])){?>
                  <div><img src="<?= Yii::$app->request->baseUrl ?>/img/kendaraan/r/<?=$model['tampak_samping_r']?>"></div>
                  <?php }?>
                  <?php if(!empty($model['tampak_samping_l'])){?>
                  <div><img src="<?= Yii::$app->request->baseUrl ?>/img/kendaraan/l/<?=$model['tampak_samping_l']?>"></div>
                  <?php }?>
                </div>
              </div>
          </div>
          <?php }?>
          <?php if(count((array)$histori)>0){?>
          <div class="panel panel-default">
              <div class="panel-heading">Data Histori Kendaraan</b></div>
              <div class="panel-body">
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <th style="width: 10px">No</th>
                      <th>Nopol Awal</th>
                      <th>Nopol Akhir</th>
                      <th>Pemegang</th>
                      <th>Keterangan</th>
                    </tr>
                    <?php $i=1; foreach ($histori as $key) {?>
                    <tr>
                      <td><?=$i?></td>
                      <td><?=$key['nopol_awal']?></td>
                      <td><?=$key['nopol_akhir']?></td>
                      <td><?=$key['nama_pemegang']?></td>
                      <td><?=$key['keterangan']?></td>
                    </tr>
                    <?php $i++;}?>
                  </tbody>
                </table>
              </div>
            </div>
          <?php }?>
        <?php }else{?>
          <div class="alert alert-danger">Maaf Data Yang Anda Cari Tidak Ditemukan</div>
        <?php }?>
      <?php }?>
    </div>
</div>
