<?php

namespace backend\controllers;

use Yii;
use common\models\Histori;
use common\models\HistoriSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\filters\AccessControl;

/**
 * HistoriController implements the CRUD actions for Histori model.
 */
class HistoriController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','view','create','updated','delete','bulk-delete','excel'],
                'rules' => [
                    [
                        'actions' => ['index','view', 'create','updated','delete','bulk-delete','excel'],
                        'allow' => true,
                        'roles' => ['@'],
                        //'matchCallback' => function ($rule, $action) {
                            //return Yii::$app->user->identity->level == 'administrator';
                        //}
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Histori models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new HistoriSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionExcel () {
        if(Yii::$app->user->identity->level != 'administrator'){
            $model = \common\models\Histori::find()->where(['instansi_id'=>Yii::$app->user->identity->instansi])->all();
        }else{
            $model = \common\models\Histori::find()->all();
        }
        
        $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
        //set template
        $template = Yii::getAlias('@app/views/histori').'/Data_History_Kendaraan.xlsx';
        $objPHPExcel = $objReader->load($template);
        $activeSheet = $objPHPExcel->getActiveSheet();
        // set orientasi dan ukuran kertas
        $activeSheet->getPageSetup()
                ->setOrientation(\PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE)
                ->setPaperSize(\PHPExcel_Worksheet_PageSetup::PAPERSIZE_FOLIO);        
      
        $baseRow=5;
        foreach ($model as $key) {


            $objPHPExcel->getActiveSheet()->getStyle('D'.$baseRow.':E'.$baseRow.'')->getAlignment()
                    ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $objPHPExcel->getActiveSheet()->getStyle('A'.$baseRow.'')->getAlignment()
                    ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $objPHPExcel->getActiveSheet()->getStyle('M'.$baseRow.'')->getAlignment()
                    ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $activeSheet->setCellValue('A'.$baseRow, $baseRow-4)
                    ->setCellValue('B'.$baseRow, $key['kendaraan']['jenis']['jenis_barang'])
                    ->setCellValue('C'.$baseRow, $key['kendaraan']['merk']['nama_merk'].'/'.$key['kendaraan']['type']['nama_type'])
                    ->setCellValue('D'.$baseRow, $key['kendaraan']['isi_silinder'])
                    ->setCellValue('E'.$baseRow, $key['kendaraan']['tahun_pembelian'])
                    ->setCellValue('F'.$baseRow, $key['kendaraan']['nomor_rangka'])
                    ->setCellValue('G'.$baseRow, $key['kendaraan']['nomor_mesin'])
                    ->setCellValue('H'.$baseRow, $key['nopol_awal'])
                    ->setCellValue('I'.$baseRow, $key['kendaraan']['nomor_bpkb'])
                    ->setCellValue('J'.$baseRow, $key['kendaraan']['pemegang']['nama_pemegang'])
                    ->setCellValue('K'.$baseRow, $key['instansi']['nama_instansi'])
                    ->setCellValue('L'.$baseRow, $key['nopol_akhir'])
                    ->setCellValue('M'.$baseRow, $key['tanggal'])
                    ->setCellValue('N'.$baseRow, $key['keterangan']);

            $objPHPExcel->getActiveSheet()->getStyle(
                'A'.$baseRow.':N'.$baseRow.''
            )->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);

            $baseRow++;
        }

        
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Data_History_Kendaraan.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
        $objWriter->save('php://output');
        exit;
    }


    /**
     * Displays a single Histori model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Histori # ".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new Histori model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Histori();  
        if(Yii::$app->user->identity->level !='administrator'){
            $model->instansi_id = Yii::$app->user->identity->instansi;
        }

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> 'Tambah Histori',
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('<i class="fa fa-close" aria-hidden="true"></i> Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('<i class="fa fa-check-square-o" aria-hidden="true"></i> Submit',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> 'Tambah Histori',
                    'content'=>'<span class="text-success">Data Histori Berhasil Ditambahkan</span>',
                    'footer'=> Html::button('<i class="fa fa-close" aria-hidden="true"></i> Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Tambah Lagi',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> 'Tambah Histori',
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('<i class="fa fa-close" aria-hidden="true"></i> Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('<i class="fa fa-check-square-o" aria-hidden="true"></i> Submit',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
       
    }

    /**
     * Updates an existing Histori model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);       

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> 'Update Histori # '.$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('<i class="fa fa-close" aria-hidden="true"></i> Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('<i class="fa fa-check-square-o" aria-hidden="true"></i> Submit',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> 'Update Histori # '.$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('<i class="fa fa-close" aria-hidden="true"></i> Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('<i class="fa fa-check-square-o" aria-hidden="true"></i> Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> 'Update Histori # '.$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('<i class="fa fa-close" aria-hidden="true"></i> Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('<i class="fa fa-check-square-o" aria-hidden="true"></i> Simapn',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing Histori model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }


    }

     /**
     * Delete multiple existing Histori model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkDelete()
    {        
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
       
    }

    /**
     * Finds the Histori model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Histori the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Histori::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
