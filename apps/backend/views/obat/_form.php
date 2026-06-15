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
/* @var $model common\models\Obat */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="obat-form">

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

    <?= $form->field($model, 'kode_obat')->textInput(['maxlength' => true,'readonly'=>true]) ?>

    <?= $form->field($model, 'nama_obat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'harga_beli',['template'=>'{label}{beginWrapper}<div class="input-group"><span class="input-group-addon">Rp.</span>{input}</div>{hint}{endWrapper}'])->textInput([ 'onKeyPress'=>"return goodchars(event,'0123456789',this)"]) ?>

    <?= $form->field($model, 'harga_jual',['template'=>'{label}{beginWrapper}<div class="input-group"><span class="input-group-addon">Rp.</span>{input}</div>{hint}{endWrapper}'])->textInput([ 'onKeyPress'=>"return goodchars(event,'0123456789',this)"]) ?>

    <?= $form->field($model, 'satuan')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(\common\models\Satuan::find()->all(), 'satuan', 'satuan'),
        'options' => ['placeholder' => 'Pilih Satuan ...','id'=>'satuan'],
            'pluginOptions' => [
                'allowClear' => false
            ],
        ]);
    ?>

    <?= $form->field($model, 'stok')->textInput() ?>

    <?php ActiveForm::end(); ?>
    
</div>
<script type="text/javascript">
      function getkey(e)
      {
        if (window.event)
          return window.event.keyCode;
        else if (e)
          return e.which;
        else
          return null;
      }

      function goodchars(e, goods, field)
      {
        var key, keychar;
        key = getkey(e);
        if (key == null) return true;
       
        keychar = String.fromCharCode(key);
        keychar = keychar.toLowerCase();
        goods = goods.toLowerCase();
       
        // check goodkeys
        if (goods.indexOf(keychar) != -1)
            return true;
        // control keys
        if ( key==null || key==0 || key==8 || key==9 || key==27 )
          return true;
          
        if (key == 13) {
          var i;
          for (i = 0; i < field.form.elements.length; i++)
            if (field == field.form.elements[i])
              break;
          i = (i + 1) % field.form.elements.length;
          field.form.elements[i].focus();
          return false;
        };
        // else return false
        return false;
      }
</script>