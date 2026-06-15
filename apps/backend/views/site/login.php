<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Tahun;

$this->title = 'Login Administrator';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="col-md-4 col-md-offset-4 text-center">
  <h2>&nbsp;</h2>
  <h2>&nbsp;</h2>
  <h2>SISTIM INFORMASI</h2>
  <h2>KENDARAAN DINAS</h2>
  <h5>KOTA MATARAM</h5>
  <p>&nbsp;</p>
  <p><span class="logo"><img src="<?= Yii::$app->request->baseUrl ?>/img/logo.png"></span></p>
  <p>&nbsp;</p>
  <div>
    <h5>Silahkan Login Melalui Form Dibawah ini.</h5>
    <p>&nbsp;</p>             
    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
      <div class="form-group">
        <?= $form->errorSummary($model)?>
        
        <?= $form->field($model, 'username',['options'=>[],'template'=>'{input}'])->textInput(['autofocus' => true,'placeholder'=>'USERNAME']) ?>

        <?= $form->field($model, 'password',['options'=>[],'template'=>'{input}'])->passwordInput(['placeholder'=>'PASSWORD']) ?>

        <?= Html::submitButton('<i class="fa fa-sign-in" aria-hidden="true"></i> MASUK', ['class' => 'btn btn-danger btn-block btn-flat', 'name' => 'login-button']) ?>
      </div> 
    <?php ActiveForm::end(); ?>
    <p class="m-t"> <span class="text-red">&copy; <?=date('Y')?> Pemerintah Kota Mataram.</span></p>
  </div>
</div>