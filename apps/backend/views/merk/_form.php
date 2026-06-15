<?php
use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
//use yii\helpers\Url;
//use yii\web\JsExpression;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
//use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Merk */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="merk-form">

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

    <?= $form->field($model, 'jenis_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(\common\models\JenisBarang::find()->all(), 'id_jenis_barang', 'jenis_barang'),
        'options' => ['placeholder' => 'Jenis Barang ...','id'=>'jenisbarang'],
            'pluginOptions' => [
                'allowClear' => false
            ],
        ]);
    ?>

    <?= $form->field($model, 'nama_merk')->textInput(['maxlength' => true]) ?>

    <?php ActiveForm::end(); ?>
    
</div>