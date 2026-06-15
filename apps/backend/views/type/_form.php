<?php
use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
//use yii\web\JsExpression;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\depdrop\DepDrop;
//use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Type */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="type-form">

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
        ])->label('Jenis');
    ?>

    <?php
    if(isset($model->jenis_id)){
        $merk = ArrayHelper::map(\common\models\Merk::find()->where(['id_merek'=>$model->merk_id])->asArray()->all(), 'id_merek', 'nama_merk');
    }else{
        $merk = [];
    }
    ?>

    <?= $form->field($model, 'merk_id')->widget(DepDrop::classname(), [
        'options' => ['id'=>'merk'],
        'type' => DepDrop::TYPE_SELECT2,
        'data' =>  $merk,
        'pluginOptions'=>[
            'depends'=>['jenisbarang'],
            'placeholder' => 'Select...',
            'url' => Url::to(['all/merk'])
        ]
    ])->label('Merk');?>

    <?= $form->field($model, 'nama_type')->textInput(['maxlength' => true]) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>