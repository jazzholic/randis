<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Download */
/* @var $form yii\widgets\ActiveForm */
?>


    <?php $form = ActiveForm::begin([
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

    <?php echo $form->errorSummary($model); ?>
    
    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>    

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'instansi')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(\common\models\Instansi::find()->all(), 'id_instansi', 'nama_instansi'),
        'options' => ['placeholder' => 'Pilih Instansi ...','id'=>'instansi'],
        'pluginOptions' => [
            'allowClear' => false,
            'disabled' => (Yii::$app->user->identity->level !='administrator' ? true:false)
        ],
    ])->label('Instansi');
    ?>

    <?= $form->field($model, 'level')->widget(Select2::classname(), [
        'data' => [ 'administrator' => 'Administrator', 'instansi' => 'Instansi','pemegang'=>'Pemegang' ],
        'options' => ['placeholder' => 'Pilih Level Akses ...'],
        'pluginOptions' => [
            'allowClear' => false
        ],
    ]);
    ?>

    <?php ActiveForm::end(); ?>