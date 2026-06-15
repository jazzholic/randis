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
/* @var $model common\models\ObatKeluar */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="obat-keluar-form">

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

    <?= $form->field($model, 'kode_transaksi')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tanggal_masuk')->textInput() ?>

    <?= $form->field($model, 'kode_obat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jumlah_keluar')->textInput() ?>

    <?= $form->field($model, 'created_user')->textInput() ?>

    <?= $form->field($model, 'created_date')->textInput() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
</div>
<?php  $script = <<< JS
        $(document).ready(function(){
            $('#obat-keluar-id_pegawai').change(
                    function() {
                        $.getJSON('../ajax/data', {
                            id : $(this).val()
                        }, function(data) {
                            $('#obat-keluar-tanggal_lahir').val(data.tanggal_lahir);
                            $('#obat-keluar-nip').val(data.nip);
                            $('#obat-keluar-pangkat').val(data.pangkat);
                            $('#obat-keluar-instansi').val(data.instansi);
                            $('#obat-keluar-nama').val(data.nama);
                        });
                    }
                );
        });
JS;

$this->registerJS($script);
?>