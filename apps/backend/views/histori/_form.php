<?php
use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
//use yii\helpers\Url;
use yii\web\JsExpression;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Histori */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="histori-form">

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

    <?php
                $url        = \yii\helpers\Url::to(['/ajax/kendaraan']);
                if(empty($model->kendaraan_id)){
                    $kendaraan = '';
                }else{
                    if(\common\models\Kendaraan::find()->where(['id_kendaraan'=>$model->kendaraan_id])->count()>0){
                        $kendaraan = \common\models\Kendaraan::find()->where(['id_kendaraan'=>$model->kendaraan_id])->one()->nomor_polisi;
                    }else{
                        $kendaraan = '';
                    }
                }
                                                                 
                echo $form->field($model, 'kendaraan_id')->widget(Select2::classname(), [
                    'initValueText' => $kendaraan, // set the initial display text
                    'options' => ['placeholder' => 'Search for a Nomor Polisi ...'],
                    //'disabled' =>true,
                    'pluginOptions' => [
                        //'disabled' => (Yii::$app->user->identity->level === 'administrator' ? false:true),
                        'allowClear' => true,
                        'minimumInputLength' => 3,
                        'language' => [
                            'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                        ],
                        'ajax' => [
                            'url' => $url,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                        'templateResult' => new JsExpression('function(kendaraan) { return kendaraan.text; }'),
                        'templateSelection' => new JsExpression('function (kendaraan) { return kendaraan.text; }'),
                    ],
                ]);
                ?>

    <?= $form->field($model, 'nopol_awal')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nopol_akhir')->textInput() ?>

    <?= $form->field($model, 'nama_pemegang')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model,'tanggal')->widget(DatePicker::className(), [
        'dateFormat'=>'yyyy-MM-dd',
        'options'=>['class'=>'form-control','placeholder'=>'Tanggal Perubahan Data'],
        'clientOptions'=>[            
            'changeYear'=>true
        ]
    ]) ?>

    <?= $form->field($model, 'instansi_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(\common\models\Instansi::find()->all(), 'id_instansi', 'nama_instansi'),
        'options' => ['placeholder' => 'Instansi ...','id'=>'instansi'],
            'pluginOptions' => [
                'allowClear' => false,
                'disabled' => (Yii::$app->user->identity->level !='administrator' ? true:false)
            ],
        ]);
    ?>

    <?= $form->field($model, 'keterangan')->textarea(['rows' => 3]) ?>

    <?php ActiveForm::end(); ?>
    
</div>