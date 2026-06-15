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
/* @var $model common\models\Pejabat */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pejabat-form">

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

    <?= $form->field($model, 'jenis_jabatan')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(\common\models\JenisJabatan::find()->all(), 'id_jabatan', 'nama_jabatan'),
        'options' => ['placeholder' => 'Jenis Jabatan ...'],
            'pluginOptions' => [
                'allowClear' => false,
            ],
        ]);
    ?>

    <?= $form->field($model, 'nama_pejabat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nip_pejabat')->textInput(['maxlength' => true,'onkeyup'=>'angka(this);']) ?>

    <?= $form->field($model, 'instansi_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(\common\models\Instansi::find()->all(), 'id_instansi', 'nama_instansi'),
        'options' => ['placeholder' => 'Instansi ...','id'=>'instansi'],
            'pluginOptions' => [
                'allowClear' => false,
                'disabled' => (Yii::$app->user->identity->level !='administrator' ? true:false)
            ],
        ]);
    ?>

    <?php ActiveForm::end(); ?>
    
</div>
<script type="text/javascript">
    function angka(e) {
        if (!/^[0-9]+$/.test(e.value)) {
            e.value = e.value.substring(0,e.value.length-1);
        }
    }
</script>