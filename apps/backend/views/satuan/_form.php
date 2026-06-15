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
/* @var $model common\models\Satuan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="satuan-form">

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

    <?= $form->field($model, 'satuan')->textInput(['maxlength' => true]) ?>

  
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
            $('#satuan-id_pegawai').change(
                    function() {
                        $.getJSON('../ajax/data', {
                            id : $(this).val()
                        }, function(data) {
                            $('#satuan-tanggal_lahir').val(data.tanggal_lahir);
                            $('#satuan-nip').val(data.nip);
                            $('#satuan-pangkat').val(data.pangkat);
                            $('#satuan-instansi').val(data.instansi);
                            $('#satuan-nama').val(data.nama);
                        });
                    }
                );
        });
JS;

$this->registerJS($script);
?>