<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use common\models\Cabang;
use common\models\Unit;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use yii\web\JsExpression;
?>

<div class="user-form">

    <?php $form = ActiveForm::begin([
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
    ]);
    ?>

    <?= $form->field($model, 'name')->textInput(['readonly'=>true]) ?>

    <?= $form->field($model, 'username')->textInput(['readonly'=>true]) ?>

    <?= $form->field($model, 'newpass')->textInput(['autofocus' => true]) ?>

    <?php ActiveForm::end(); ?>
    
</div>