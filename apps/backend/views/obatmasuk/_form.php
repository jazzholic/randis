<?php
use yii\helpers\Html;
use yii\helpers\BaseHtml;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
//use yii\helpers\Url;
//use yii\web\JsExpression;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
//use kartik\widgets\DatePicker;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\ObatMasuk */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="obat-masuk-form">

    <?php $form = ActiveForm::begin([
        'layout' => 'horizontal',
        //'name' => 'formobat',
        'options'=>['name'=>'formobat'],
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

    <?= $form->field($model, 'kode_transaksi')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model,'tanggal_masuk')->widget(DatePicker::className(), [
        'dateFormat'=>'yyyy-MM-dd',
        'options'=>['class'=>'form-control'],
        'clientOptions'=>[            
            'changeYear'=>true
        ]
    ]) ?>

    <hr>

    <?= $form->field($model, 'kode_obat')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(\common\models\Obat::find()->all(), 'kode_obat', 'full'),
        'options' => ['placeholder' => 'Kode Obat ...','id'=>'kodeobat','onchange'=>'tampil_obat(this);'],
            'pluginOptions' => [
                'allowClear' => false
            ],
        ]);
    ?>

    <span id="show">
        <?= $form->field($model, 'stok')->textInput(['maxlength' => true,'id'=>'stok','readonly'=>true]) ?>
    </span>

    <?= $form->field($model, 'jumlah_masuk')->textInput(['id'=>'jumlah_masuk']) ?>

    <?= $form->field($model, 'total_stok')->textInput(['maxlength' => true,'readonly'=>true,'id'=>'total_stok']) ?>

    <?= BaseHtml::activeHiddenInput($model, 'stok'); ?>

    <?php ActiveForm::end(); ?>
    
</div>
<script type="text/javascript">
    function angka(e) {
        if (!/^[0-9]+$/.test(e.value)) {
            e.value = e.value.substring(0,e.value.length-1);
        }
    }

    function tampil_obat(input){
        var num = input.value;

        $.post("ajax/kodeobat", {
            kode_obat: num,
        }, function(response) {      
            $('#show').html(response)
            document.getElementById('jumlah_masuk').focus();
        });
    }

    var input1  = document.getElementById("obatmasuk-stok");
    var input2  = document.getElementById("jumlah_masuk");
    
    var output  = document.getElementById("total_stok");

    function changeInput(e){ 

        var jumlah = input2.value;
        //var stok   = input1.value;

        if(jumlah>0){
            var total = eval(input1.value) + eval(input2.value)
            output.value = total;
        }else{
            output.value = input1.value;
        }
        
    }

    input1.onchange = changeInput;
    input2.onchange = changeInput;
</script>
<?php $script = <<< JS
    $(document).ready(function(){
        $('#kodeobat').change(
            function() {
                $.getJSON('ajax/data', {
                    id : $(this).val()
                }, function(data) {
                    $('#obatmasuk-stok').val(data.stok);
                });
            }
        );
    });
JS;

$this->registerJS($script);
?>