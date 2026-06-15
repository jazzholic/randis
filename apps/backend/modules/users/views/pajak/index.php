<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

CrudAsset::register($this);

$this->title = 'Riwayat Pajak Kendaraan';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row">
  <div class="col-md-12">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class=""><a href="<?=Yii::$app->getUrlManager()->createUrl(['site/index']);?>">Data Kendaraan</a></li>
        <li class=""><a href="<?=Yii::$app->getUrlManager()->createUrl(['users/histori']);?>">Histori Kendaraan</a></li>
        <li class="active"><a href="#settings" data-toggle="tab" aria-expanded="false">Pajak Kendaraan</a></li>
        <li class=""><a href="<?=Yii::$app->getUrlManager()->createUrl(['users/perawatan']);?>">Data Perawatan</a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="settings">
            <div id="ajaxCrudDatatable">
                <?=GridView::widget([
                    'id'=>'crud-datatable',
                    'dataProvider' => $dataProvider,
                    'pager' => [
                        'firstPageLabel' => 'Pertama',
                        'lastPageLabel' => 'Terakhir',
                    ],
                    //'filterModel' => $searchModel,
                    'pjax'=>true,
                    'columns' => require(__DIR__.'/_columns.php'),
                    'toolbar'=> [
                        ['content'=>
                            Html::a('<i class="fa fa-plus"></i> Tambah Data', ['create'],
                            ['role'=>'modal-remote','title'=> 'Tambah Riwayat Pajak','class'=>'btn btn-danger btn-box-tool','style' => 'color:#fff'])
                        ],
                    ],          
                    'striped' => true,
                    'condensed' => true,
                    'responsive' => true,          
                    'panel' => [                        
                        'heading' => '',
                        'before'=>false,
                        'after'=>false,
                    ]
                ])?>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php Modal::begin([
    'options' => [
        'id' => 'ajaxCrudModal',
        'tabindex' => false // important for Select2 to work properly
    ],
    'footer' => '',// always need it for jquery plugin
    //'size' => 'modal-lg'
])?>
<?php Modal::end(); ?>