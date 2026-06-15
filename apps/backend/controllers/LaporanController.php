<?php

namespace backend\controllers;

use Yii;
use Mpdf;
use common\models\ReportForm;
use common\models\Report;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\filters\AccessControl;
use yii\data\ArrayDataProvider;

class LaporanController extends \yii\web\Controller
{

    public function behaviors()
    {
        return [
            
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','create','updated','delete','import','harian'],
                'rules' => [
                    [
                        'actions' => ['all','index','create','updated','delete','import','harian'],
                        'allow' => true,
                        'roles' => ['@'],
                        //'matchCallback' => function ($rule, $action) {
                            //return Yii::$app->user->identity->level === 'administrator';
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

    public function actionAll()
    {
        $model  = new ReportForm();
        if(Yii::$app->user->identity->level != 'administrator'){
            $model->instansi = Yii::$app->user->identity->instansi;
        }
        
        $report = new Report;
        
        $model->load(Yii::$app->request->queryParams);
        
        $dataProvider = new ArrayDataProvider([
            'allModels' => $report->arrayAll($model),
            'pagination'=> [
                'pageSize'=>10,
            ]
        ]);
             
        return $this->render('all', [
            'model'=>$model,
            'dataProvider'=>$dataProvider
        ]);
    }

    public function actionAllpdf(array $params) {
        $model  = new ReportForm;
        $report = new Report();
        
        $model->instansi = $params['instansi'];

        $instansi = \common\models\Instansi::find()->where(['id_instansi'=>$model->instansi])->one();
        
        $dataProvider = new ArrayDataProvider([
            'allModels' => $report->arrayAll($model),
            'pagination'=> [
                'pageSize'=>FALSE,
            ]
        ]);
        
        $html = $this->renderPartial('allpdf', ['dataProvider'=>$dataProvider,'model'=>$model,'instansi'=>$instansi]);
        
        //$mpdf = new mPDF('c', 'A4','','',0,0,0,0,0,0);
        //$mpdf = new \Mpdf\Mpdf('','Legal',0,'',10,10);
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'Legal-L']);
        $mpdf->AddPage('L');
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;
        $mpdf->WriteHTML($html);
        $mpdf->Output();        
        exit;
    }

    public function actionKondisi()
    {
        $model  = new ReportForm();
        if(Yii::$app->user->identity->level != 'administrator'){
            $model->instansi = Yii::$app->user->identity->instansi;
        }
        
        $report = new Report;
        
        $model->load(Yii::$app->request->queryParams);
        
        $dataProvider = new ArrayDataProvider([
            'allModels' => $report->arrayKondisi($model),
            'pagination'=> [
                'pageSize'=>10,
            ]
        ]);
             
        return $this->render('kondisi', [
            'model'=>$model,
            'dataProvider'=>$dataProvider
        ]);
    }

    public function actionKondisipdf(array $params) {
        $model  = new ReportForm;
        $report = new Report();
        
        $model->instansi = $params['instansi'];

        $instansi = \common\models\Instansi::find()->where(['id_instansi'=>$model->instansi])->one();
        
        $dataProvider = new ArrayDataProvider([
            'allModels' => $report->arrayKondisi($model),
            'pagination'=> [
                'pageSize'=>FALSE,
            ]
        ]);
        
        $html = $this->renderPartial('kondisipdf', ['dataProvider'=>$dataProvider,'model'=>$model,'instansi'=>$instansi]);
        
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'Legal-L']);
        $mpdf->AddPage('L');
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;
        $mpdf->WriteHTML($html);
        $mpdf->Output();        
        exit;
    }


    public function actionBbm()
    {
        return $this->render('bbm');
    }

    public function actionBbmpdf()
    {
        return $this->render('bbmpdf');
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionPajak()
    {
        $model  = new ReportForm();
        if(Yii::$app->user->identity->level != 'administrator'){
            $model->instansi = Yii::$app->user->identity->instansi;
        }
        
        $report = new Report;
        
        $model->load(Yii::$app->request->queryParams);
        
        $dataProvider = new ArrayDataProvider([
            'allModels' => $report->arrayPajak($model),
            'pagination'=> [
                'pageSize'=>10,
            ]
        ]);
             
        return $this->render('pajak', [
            'model'=>$model,
            'dataProvider'=>$dataProvider
        ]);
    }

    public function actionPajakpdf(array $params)
    {
        $model  = new ReportForm;
        $report = new Report();
        
        $model->instansi = $params['instansi'];

        $instansi = \common\models\Instansi::find()->where(['id_instansi'=>$model->instansi])->one();
        
        $dataProvider = new ArrayDataProvider([
            'allModels' => $report->arrayPajak($model),
            'pagination'=> [
                'pageSize'=>FALSE,
            ]
        ]);
        
        $html = $this->renderPartial('pajakpdf', ['dataProvider'=>$dataProvider,'model'=>$model,'instansi'=>$instansi]);
        
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'Legal-L']);
        $mpdf->AddPage('L');
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;
        $mpdf->WriteHTML($html);
        $mpdf->Output();        
        exit;
    }

    public function actionPerawatan()
    {
        $model  = new ReportForm();
        if(Yii::$app->user->identity->level != 'administrator'){
            $model->instansi = Yii::$app->user->identity->instansi;
        }
        
        $report = new Report;
        
        $model->load(Yii::$app->request->queryParams);
        
        $dataProvider = new ArrayDataProvider([
            'allModels' => $report->arrayPerawatan($model),
            'pagination'=> [
                'pageSize'=>10,
            ]
        ]);
             
        return $this->render('perawatan', [
            'model'=>$model,
            'dataProvider'=>$dataProvider
        ]);
    }

    public function actionPerawatanpdf(array $params)
    {
        $model  = new ReportForm;
        $report = new Report();
        
        $model->instansi = $params['instansi'];

        $instansi = \common\models\Instansi::find()->where(['id_instansi'=>$model->instansi])->one();
        
        $dataProvider = new ArrayDataProvider([
            'allModels' => $report->arrayPerawatan($model),
            'pagination'=> [
                'pageSize'=>FALSE,
            ]
        ]);
        
        $html = $this->renderPartial('perawatanpdf', ['dataProvider'=>$dataProvider,'model'=>$model,'instansi'=>$instansi]);
        
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'Legal-L']);
        $mpdf->AddPage('L');
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;
        $mpdf->WriteHTML($html);
        $mpdf->Output();        
        exit;
    }

}
