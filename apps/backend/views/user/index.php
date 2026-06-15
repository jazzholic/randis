<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pengaturan User';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="user-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'pager' => [
                'firstPageLabel' => 'Pertama',
                'lastPageLabel' => 'Terakhir',
            ],
            'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns.php'),
            'toolbar'=> [
                ['content'=> Html::a('<i class="fa fa-plus"></i> Tambah Data', ['create'],
                    ['role'=>'modal-remote','title'=> 'Tambah User','class'=>'btn btn-success btn-box-tool','style' => 'color:#fff'])],
            ],          
            'striped' => true,
            'condensed' => true,
            'responsive' => true,          
            'panel' => [
                'type' => 'primary', 
                'heading' => '<i class="fa fa-user-secret text-blue"></i> Daftar User',
                'before'=>'',
                'after'=>'<div class="clearfix"></div>',
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