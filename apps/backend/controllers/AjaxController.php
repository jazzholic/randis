<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\db\Query;
use yii\data\Pagination;
use common\models\Pemegang;

class AjaxController extends \yii\web\Controller
{

    public function actionPemegang($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            if(Yii::$app->user->identity->level == 'administrator'){
                $query->select('id_pemegang AS id, nama_pemegang AS text')
                    ->from('pemegang')
                    ->where(['like', 'nama_pemegang', $q])
                    ->limit(20);
            }else{
                $query->select('id_pemegang AS id, nama_pemegang AS text')
                    ->from('pemegang')
                    ->where(['like', 'nama_pemegang', $q])
                    ->andWhere(['instansi_id'=>Yii::$app->user->identity->instansi])
                    ->limit(20);
            }
            $command = $query->createCommand();
            $data    = $command->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => Pemegang::find()->where(['id_pemegang'=>$id])->one()->nama_pemegang];
        }
        return $out;
    }

    public function actionKendaraan($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            if(Yii::$app->user->identity->level == 'administrator'){
                $query->select('id_kendaraan AS id, nomor_polisi AS text')
                    ->from('kendaraan')
                    ->where(['like', 'nomor_polisi', $q])
                    ->limit(20);
            }else{
                $query->select('id_kendaraan AS id, nomor_polisi AS text')
                    ->from('kendaraan')
                    ->where(['like', 'nomor_polisi', $q])
                    ->andWhere(['instansi_id'=>Yii::$app->user->identity->instansi])
                    ->limit(20);
            }
            $command = $query->createCommand();
            $data    = $command->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => \common\models\Kendaraan::find()->where(['id_kendaraan'=>$id])->one()->nomor_polisi];
        }
        return $out;
    }

    public function actionAll($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            
            $query->select('id_kendaraan AS id, nomor_polisi AS text')
                ->from('kendaraan')
                ->where(['like', 'nomor_polisi', $q])
                ->limit(20);

            $command = $query->createCommand();
            $data    = $command->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => \common\models\Kendaraan::find()->where(['id_kendaraan'=>$id])->one()->nomor_polisi];
        }
        return $out;
    }

    public function actionData()
    {
        if(isset($_GET['id'])){
            $id    = $_GET['id'];
            $model = \common\models\Obat::find()->where(['kode_obat'=>$id])->one();
            
            $data  = array(
                'stok'=> $model['stok'],
            );
            echo json_encode($data) ;            
        }
    }

}