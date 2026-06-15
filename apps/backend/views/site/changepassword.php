<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Rubah Password';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-lock icon-title"></i> <?= Html::encode($this->title) ?></h3>
    </div>
    <?php $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'id' => 'login-form',
        'options' => ['enctype' => 'multipart/form-data'],
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
    ]);
    ?>
    <div class="box-body">
        <div class="site-login">
            <div class="row">
                <div class="col-lg-7">                     

                    <?= $form->field($model, 'oldpass')->passwordInput(['autofocus' => true]) ?>

                    <?= $form->field($model, 'newpass')->passwordInput() ?>

                    <?= $form->field($model, 'repeatnewpass')->passwordInput() ?>

                    <?php 
                    //$form->field($model, 'reCaptcha')->widget(\himiklab\yii2\recaptcha\ReCaptcha::className()) 
                    ?>                   
                </div>
                <div class="col-lg-5">
                    <?php echo $form->errorSummary($model); ?>
                    <div class="alert alert-info alert-dismissible" style=""><p>Catatan :</p><ul><li>Password Harus Mengandung Minimal 1 Angka dan 1 Spesial Karakter (!@#$%^&*)</li><li>Password Minimal 6 Karakter</li></ul></div>
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer">
        <div class="row">
            <div class="col-lg-7">
                <div class="form-group">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-8">
                        <?= Html::submitButton('<i class="fa fa-sign-in" aria-hidden="true"></i> Submit', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>