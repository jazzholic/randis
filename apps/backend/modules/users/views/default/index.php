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

$this->title = 'Histori Kendaraan Dinas';
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
              <img class="profile-user-img img-responsive img-circle" src="../../dist/img/user4-128x128.jpg" alt="User profile picture">

              <h3 class="profile-username text-center">Nina Mcintire</h3>

              <p class="text-muted text-center">Software Engineer</p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Followers</b> <a class="pull-right">1,322</a>
                </li>
                <li class="list-group-item">
                  <b>Following</b> <a class="pull-right">543</a>
                </li>
                <li class="list-group-item">
                  <b>Friends</b> <a class="pull-right">13,287</a>
                </li>
              </ul>

              <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
  </div>
  <div class="col-md-9">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class=""><a href="<?=Yii::$app->getUrlManager()->createUrl(['site/index']);?>">Data Kendaraan</a></li>
        <li class="active"><a href="#settings" data-toggle="tab" aria-expanded="false">Histori Kendaraan</a></li>
        <li class=""><a href="<?=Yii::$app->getUrlManager()->createUrl(['users/pajak']);?>">Pajak Kendaraan</a></li>
        <li class=""><a href="<?=Yii::$app->getUrlManager()->createUrl(['users/perawatan']);?>">Data Perawatan</a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="timeline">

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