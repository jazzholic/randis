<?php

namespace backend\controllers;

use Yii;
use yii\helpers\Json;
use common\models\Merk;
use common\models\Type;
use yii\db\Query;


class AllController extends \yii\web\Controller
{

    public function actionMerk() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $id   = $parents[0];
                $out = Merk::getMerkList($id);
                return Json::encode(['output'=>$out, 'selected'=>'']);
            }
        }
        return Json::encode(['output'=>'', 'selected'=>'']);
    }
    public function actionType() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $id   = $parents[0];
                $out = Type::getTypeList($id);
                return Json::encode(['output'=>$out, 'selected'=>'']);
            }
        }
        return Json::encode(['output'=>'', 'selected'=>'']);
    }

    public function actionProd() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $ids = $_POST['depdrop_parents'];
            $jenis_id = empty($ids[0]) ? null : $ids[0];
            $merk_id = empty($ids[1]) ? null : $ids[1];
            if ($jenis_id != null) {
               $out = Type::getProdList($jenis_id, $merk_id);
              
               return Json::encode(['output'=>$out, 'selected'=>'']);
            }
        }
        return Json::encode(['output'=>'', 'selected'=>'']);
    }
}