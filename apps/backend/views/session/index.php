<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SessionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manage Session';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="session-index">
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
            'toolbar'=> [],          
            'striped' => true,
            'condensed' => true,
            'responsive' => true,          
            'panel' => [
                'type' => 'primary', 
                'heading' => '<i class="fa fa-bookmark-o text-green"></i> Data Session',
                'before'=>'',
                'after'=>BulkButtonWidget::widget([
                    'buttons'=>Html::a('<i class="fa fa-trash"></i>&nbsp; Delete All',["bulk-delete"] ,
                    [
                        "class"=>"btn btn-danger btn-xs",
                        'role'=>'modal-remote-bulk',
                        'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                        'data-request-method'=>'post',
                        'data-confirm-title'=>'Are you sure?',
                        'data-confirm-message'=>'Are you sure want to delete this item'
                    ]),
                ]).                        
                '<div class="clearfix"></div>',
            ]
        ])?>
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