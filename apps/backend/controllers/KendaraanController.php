<?php

namespace backend\controllers;

use Yii;
use common\models\Kendaraan;
use common\models\KendaraanSearch;
use common\models\Histori;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\filters\AccessControl;

/**
 * KendaraanController implements the CRUD actions for Kendaraan model.
 */
class KendaraanController extends Controller
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
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->level != 'pemegang';
                        }
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
     * Lists all Kendaraan models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new KendaraanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if(Yii::$app->user->identity->level !='administrator'){
            $searchModel->instansi_id = Yii::$app->user->identity->instansi;
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Kendaraan model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> 'Detail Kendaraan',
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
     * Creates a new Kendaraan model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Kendaraan(); 
        if(Yii::$app->user->identity->level !='administrator'){
            $model->instansi_id = Yii::$app->user->identity->instansi;
        }
        $model->setScenario('insert'); 

        $histori = new Histori();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> 'Tambah Kendaraan',
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('<i class="fa fa-close" aria-hidden="true"></i> Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('<i class="fa fa-check-square-o" aria-hidden="true"></i> Submit',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){

                $pemegang = \common\models\Pemegang::find()->where(['id_pemegang'=>$model->pemegang_id])->one();

                $histori->kendaraan_id  = $model->id_kendaraan;
                $histori->nopol_awal    = $model->nomor_polisi;
                $histori->nopol_akhir   = $model->nomor_polisi;
                $histori->nama_pemegang = $pemegang['nama_pemegang'];
                $histori->tanggal       = date('Y-m-d');
                $histori->instansi_id   = $model->instansi_id;
                $histori->keterangan    = 'Kendaraan Baru';
                $histori->save();

                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> 'Tambah Kendaraan',
                    'content'=>'<span class="text-success">Data Kendaraan Berhasil Ditambahkan</span>',
                    'footer'=> Html::button('<i class="fa fa-close" aria-hidden="true"></i> Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Tambah Lagi',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> 'Tambah Kendaraan',
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('<i class="fa fa-close" aria-hidden="true"></i> Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('<i class="fa fa-check-square-o" aria-hidden="true"></i> Submit',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }
        }
    }

    /**
     * Updates an existing Kendaraan model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id); 
        $model->nomor_polisi_lama = $model->nomor_polisi;
        $model->pemegang_lama = $model->pemegang_id;
        $model->instansi_lama = $model->instansi_id;     
        $model->setScenario('update'); 

        $histori = new Histori();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> 'Update Kendaraan',
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('<i class="fa fa-close" aria-hidden="true"></i> Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('<i class="fa fa-check-square-o" aria-hidden="true"></i> Submit',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){

                $pemegang = \common\models\Pemegang::find()->where(['id_pemegang'=>$model->pemegang_id])->one();

                if(($model->nomor_polisi_lama != $model->nomor_polisi) OR ($model->pemegang_lama != $model->pemegang_id) OR ($model->instansi_lama != $model->instansi_id) ){

                    $histori->kendaraan_id  = $model->id_kendaraan;
                    $histori->nopol_awal    = $model->nomor_polisi_lama;
                    $histori->nopol_akhir   = $model->nomor_polisi;
                    $histori->nama_pemegang = $pemegang['nama_pemegang'];
                    $histori->tanggal       = date('Y-m-d');
                    $histori->instansi_id   = $model->instansi_id;
                    $histori->keterangan    = $model->keterangan;
                    $histori->save();
                }

                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> 'Update Kendaraan',
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('<i class="fa fa-close" aria-hidden="true"></i> Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('<i class="fa fa-check-square-o" aria-hidden="true"></i> Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> 'Update Kendaraan',
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('<i class="fa fa-close" aria-hidden="true"></i> Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('<i class="fa fa-check-square-o" aria-hidden="true"></i> Simapn',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }
    }

    /**
     * Delete an existing Kendaraan model.
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
     * Delete multiple existing Kendaraan model.
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
     * Finds the Kendaraan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Kendaraan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Kendaraan::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
