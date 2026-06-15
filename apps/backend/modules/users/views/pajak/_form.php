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
/* @var $model common\models\RiwayatPajak */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="riwayat-pajak-form">

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
        $url  = \yii\helpers\Url::to(['/ajax/kendaraan']);
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
                'disabled' => true,
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

    <?= $form->field($model,'tanggal_bayar')->widget(DatePicker::className(), [
        'dateFormat'=>'yyyy-MM-dd',
        'options'=>['class'=>'form-control','placeholder'=>'Tanggal Bayar'],
        'clientOptions'=>[            
            'changeYear'=>true
        ]
    ]) ?>

    <?= $form->field($model, 'jumlah_bayar')->textInput(['maxlength' => true,'onkeyup'=>'angka(this);']) ?>

    <?= $form->field($model,'tanggal_expired')->widget(DatePicker::className(), [
        'dateFormat'=>'yyyy-MM-dd',
        'options'=>['class'=>'form-control','placeholder'=>'Tanggal Expired'],
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

    <?php ActiveForm::end(); ?>
    
</div>
<script type="text/javascript">
    function angka(e) {
        if (!/^[0-9]+$/.test(e.value)) {
            e.value = e.value.substring(0,e.value.length-1);
        }
    }
</script>