<?php
use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
//use yii\helpers\Url;
//use yii\web\JsExpression;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\widgets\FileInput;
//use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Pemegang */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pemegang-form">

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

    <?= $form->field($model, 'nama_pemegang')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nip_pemegang')->textInput(['maxlength' => true,'onkeyup'=>'angka(this);']) ?>

    <?= $form->field($model, 'golongan_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(\common\models\Golongan::find()->all(), 'id', 'golpang'),
        'options' => ['placeholder' => 'Golongan ...','id'=>'golpang'],
            'pluginOptions' => [
                'allowClear' => false,
            ],
        ]);
    ?>

    <?= $form->field($model, 'jenis_kelamin')->widget(Select2::classname(), [
        'data' => [ 'Laki-laki' => 'Laki-laki', 'Perempuan' => 'Perempuan', ],
        'options' => ['placeholder' => 'Jenis Kelamin ...','id'=>'jk'],
            'pluginOptions' => [
                'allowClear' => false,                
            ],
        ]);
    ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jabatan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alamat')->textarea(['rows' => 3]) ?>

    <?= $form->field($model, 'no_telp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'instansi_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(\common\models\Instansi::find()->all(), 'id_instansi', 'nama_instansi'),
        'options' => ['placeholder' => 'Instansi ...','id'=>'instansi'],
            'pluginOptions' => [
                'allowClear' => false,
                'disabled' => (Yii::$app->user->identity->level !='administrator' ? true:false)
            ],
        ]);
    ?>

    <?= $form->field($model, 'namafile')->widget(FileInput::classname(), [
        'options' => ['accept' => 'image/*'],
        'pluginOptions' => [
            'showPreview' => false,
            'showCaption' => true,
            'showRemove' => false,
            'showUpload' => false
        ],
    ])->label('Foto');
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