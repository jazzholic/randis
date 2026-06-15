<?php
use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
//use yii\helpers\Url;
//use yii\web\JsExpression;
//use yii\helpers\ArrayHelper;
//use kartik\widgets\Select2;
//use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Golongan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="golongan-form">

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

    <?= $form->field($model, 'golongan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pangkat')->textInput(['maxlength' => true]) ?>

    <?php ActiveForm::end(); ?>
    
</div>