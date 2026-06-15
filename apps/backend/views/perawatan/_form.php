<?php
use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
//use yii\helpers\Url;
use yii\web\JsExpression;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
//use kartik\widgets\DatePicker;
use yii\jui\DatePicker;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\Perawatan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="perawatan-form">

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

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab">Data 1</a></li>
            <li><a href="#tab_2" data-toggle="tab">Data 2</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">

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

                <?= $form->field($model,'tanggal')->widget(DatePicker::className(), [
                    'dateFormat'=>'yyyy-MM-dd',
                    'options'=>['class'=>'form-control'],
                    'clientOptions'=>[            
                        'changeYear'=>true
                    ]
                ]) ?>

                <?= $form->field($model, 'rekanan')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'bbm_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(\common\models\JenisBbm::find()->all(), 'id_bbm', 'jenis_bbm'),
                    'options' => ['placeholder' => 'Jenis BBM ...'],
                        'pluginOptions' => [
                            'allowClear' => false
                        ],
                    ]);
                ?>

                <?= $form->field($model, 'jumlah_liter',['template'=>'{label}{beginWrapper}<div class="input-group">{input}<span class="input-group-addon">LTR</span></div>{endWrapper}'])->textInput(['onkeyup'=>'angka(this);']) ?>

                <?= $form->field($model, 'jumlah_kilometer',['template'=>'{label}{beginWrapper}<div class="input-group">{input}<span class="input-group-addon">Km</span></div>{endWrapper}'])->textInput(['onkeyup'=>'angka(this);']) ?>

                <?= $form->field($model, 'total_biaya',['template'=>'{label}{beginWrapper}<div class="input-group"><span class="input-group-addon">Rp.</span>{input}</div>{endWrapper}'])->textInput(['onkeyup'=>'angka(this);']) ?>
            </div>
            <div class="tab-pane" id="tab_2">

                <?= $form->field($model, 'keterangan')->textarea(['rows' => 6,'id'=>'keterangan']) ?>

                <?= $form->field($model, 'lampiran')->widget(FileInput::classname(), [
                    'options' => ['accept' => 'image/*'],
                    'pluginOptions' => [
                        'showPreview' => false,
                        'showCaption' => true,
                        'showRemove' => false,
                        'showUpload' => false
                    ],
                ]);
                ?>

                <?= $form->field($model, 'instansi_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(\common\models\Instansi::find()->all(), 'id_instansi', 'nama_instansi'),
                    'options' => ['placeholder' => 'Instansi ...','id'=>'instansi'],
                        'pluginOptions' => [
                            'allowClear' => false,
                            'disabled' => (Yii::$app->user->identity->level !='administrator' ? true:false)
                        ],
                    ]);
                ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
    
</div>
<script type="text/javascript">
    function angka(e) {
        if (!/^[0-9]+$/.test(e.value)) {
            e.value = e.value.substring(0,e.value.length-1);
        }
    }
</script>
<?php  $script = <<< JS

    $("#keterangan").wysihtml5(
        {
          toolbar: {
            "font-styles": false, //Font styling, e.g. h1, h2, etc. Default true
            "emphasis": true, //Italics, bold, etc. Default true
            "lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
            "html": true, //Button which allows you to edit the generated HTML. Default false
            "link": false, //Button to insert a link. Default true
            "image": false, //Button to insert an image. Default true,
            "color": false, //Button to change color of font  
            "blockquote": true,
          }
        }
    );

JS;
$this->registerJS($script);
?>