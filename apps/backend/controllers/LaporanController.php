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
                'only' => ['all','allpdf','allexcel','index','create','updated','delete','import','harian'],
                'rules' => [
                    [
                        'actions' => ['all','allpdf','allexcel','index','create','updated','delete','import','harian'],
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
        if(!Yii::$app->user->isGuest && Yii::$app->user->identity->level != 'administrator'){
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

    // public function actionAllpdf(array $params) {
    //     $model  = new ReportForm;
    //     $report = new Report();
        
    //     $model->instansi = $params['instansi'];

    //     $instansi = \common\models\Instansi::find()->where(['id_instansi'=>$model->instansi])
    //     ->one();
        
    //     $dataProvider = new ArrayDataProvider([
    //         'allModels' => $report->arrayAll($model),
    //         'pagination'=> [
    //             'pageSize'=>FALSE,
    //         ]
    //     ]);
        
    //     $html = $this->renderPartial('allpdf', ['dataProvider'=>$dataProvider,'model'=>$model,'instansi'=>$instansi]);
        
    //     //$mpdf = new mPDF('c', 'A4','','',0,0,0,0,0,0);
    //     //$mpdf = new \Mpdf\Mpdf('','Legal',0,'',10,10);
    //     $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'Legal-L']);
    //     $mpdf->AddPage('L');
    //     $mpdf->SetDisplayMode('fullpage');
    //     $mpdf->list_indent_first_level = 0;
    //     $mpdf->WriteHTML($html);
    //     $mpdf->Output();        
    //     exit;
    // }
    public function actionAllpdf(array $params)
{
    $model  = new ReportForm;
    $report = new Report();

    $model->instansi = $params['instansi'];

    if ((int) $model->instansi === 0) {
        $instansi = [
            'nama_instansi' => 'SEMUA INSTANSI',
            'alamat'        => '',
            'telp'          => '',
            'fax'           => '',
            'email'         => ''
        ];
    } else {
        $instansi = \common\models\Instansi::find()
            ->where(['id_instansi' => $model->instansi])
            ->one();
    }

    $pejabat = \common\models\Pejabat::find()
        ->where([
            'instansi_id'   => $model->instansi,
            'jenis_jabatan' => 6
        ])
        ->one();

    $dataProvider = new ArrayDataProvider([
        'allModels' => $report->arrayAll($model),
        'pagination' => [
            'pageSize' => false,
        ]
    ]);

    $html = $this->renderPartial('allpdf', [
        'dataProvider' => $dataProvider,
        'model'        => $model,
        'instansi'     => $instansi,
        'pejabat'      => $pejabat,
    ]);

    $mpdf = new \Mpdf\Mpdf([
        'mode'   => 'utf-8',
        'format' => 'Legal-L'
    ]);

    $mpdf->AddPage('L');
    $mpdf->SetDisplayMode('fullpage');
    $mpdf->list_indent_first_level = 0;
    $mpdf->WriteHTML($html);
    $mpdf->Output();

    exit;
}

    public function actionAllexcel(array $params)
    {
        if (Yii::$app->user->isGuest || Yii::$app->user->identity->level !== 'administrator') {
            throw new \yii\web\ForbiddenHttpException('Hanya administrator.');
        }

        $model  = new ReportForm;
        $report = new Report();
        $model->instansi = $params['instansi'];

        if ((int) $model->instansi !== 0) {
            return $this->redirect(['laporan/allpdf', 'params' => $params]);
        }

        $data = $report->arrayAll($model);

        $objPHPExcel = new \PHPExcel();
        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->setTitle('Laporan Semua Instansi');

        $headers = [
            'NO', 'JENIS BARANG', 'MERK/TYPE', 'UKURAN/CC', 'TAHUN PEMBELIAN',
            'KONDISI', 'HARGA PEMBELIAN', 'RANGKA', 'MESIN', 'POLISI', 'BPKB',
            'NAMA PEMEGANG', 'KETERANGAN'
        ];

        foreach ($headers as $index => $label) {
            $sheet->setCellValueByColumnAndRow($index , 1, $label);
        }

        $sheet->getStyle('A1:M1')->getFont()->setBold(true);
        $sheet->getStyle('A1:M1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $row = 2;
        foreach ($data as $key) {
            $sheet->setCellValue('A' . $row, $row - 1);
            $sheet->setCellValue('B' . $row, $key['jenis_barang']);
            $sheet->setCellValue('C' . $row, ($key['nama_merk'] ?? '') . '/' . ($key['nama_type'] ?? ''));
            $sheet->setCellValue('D' . $row, $key['isi_silinder']);
            $sheet->setCellValue('E' . $row, $key['tahun_pembelian']);
            $sheet->setCellValue('F' . $row, $key['kondisi'] ?? '-');
            $sheet->setCellValue('G' . $row, $key['harga_pembelian'] ?? 0);
            $sheet->setCellValue('H' . $row, $key['nomor_rangka']);
            $sheet->setCellValue('I' . $row, $key['nomor_mesin']);
            $sheet->setCellValue('J' . $row, $key['nomor_polisi']);
            $sheet->setCellValue('K' . $row, $key['nomor_bpkb']);
            $sheet->setCellValue('L' . $row, $key['nama_pemegang']);
            $sheet->setCellValue('M' . $row, $key['keterangan'] ?? '');
            $row++;
        }

        foreach (range('A', 'M') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        if ($row > 2) {
            $sheet->getStyle('G2:G' . ($row - 1))->getNumberFormat()
                ->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Laporan_All_Instansi.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $writer->save('php://output');
        exit;
    }

    public function actionKondisi()
    {
        $model  = new ReportForm();
        if(!Yii::$app->user->isGuest && Yii::$app->user->identity->level != 'administrator'){
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
        if(!Yii::$app->user->isGuest && Yii::$app->user->identity->level != 'administrator'){
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
        if(!Yii::$app->user->isGuest && Yii::$app->user->identity->level != 'administrator'){
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
