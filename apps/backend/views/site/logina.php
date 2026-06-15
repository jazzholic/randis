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


<div class="login-box">
  <div class="login-logo">
    <a href=""><img src="<?= Yii::$app->request->baseUrl ?>/img/learn.png" class="center-block" alt="Responsive image"></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-title"><a href="#"><b><span class="text-maroon">SIM</span> <span class="text-purple">Jurnal</span></b> Harian</a></p>

    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
        <?= $form->field($model, 'username',['options'=>['class'=>'form-group has-feedback'],'template'=>'{input}<span class="fa fa-user form-control-feedback"></span>'])->textInput(['autofocus' => true,'placeholder'=>'Username']) ?>

        <?= $form->field($model, 'password',['options'=>['class'=>'form-group has-feedback'],'template'=>'{input}<span class="fa fa-lock form-control-feedback"></span>'])->passwordInput(['placeholder'=>'Password']) ?>

        <div class="row">
            <div class="col-xs-8">
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <?= Html::submitButton('<i class="fa fa-sign-in" aria-hidden="true"></i> Sign in', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
            </div>
            <!-- /.col -->
        </div>

    <?php ActiveForm::end(); ?>
  </div>
  <!-- /.login-box-body -->
  <p></p>
  <p class="text-center">
    <small><span class="text-blue">Copyright  &copy; <?= date('Y') ?> By : </span><span class="text-maroon"><b>Kabupaten Pasaman</b></span>.</small>
  </p>
</div>
<!-- /.login-box -->