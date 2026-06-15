<?php

namespace common\models;

use yii\base\Model;
use Yii;

/**
 * Description of filtReport
 *
 * @author yasrul
 */
class ReportForm extends Model {
    //put your code here
    public $instansi;
    public $tanggal;
    public $bulan;


    public function rules() {
        return [
            [['instansi'], 'integer'],
            [['tanggal','bulan'], 'date','format'=>'yyyy-M-d'],
            ['bulan', 'compare', 'compareAttribute'=>'tanggal','operator'=>'>='],
        ];
    }

    public function attributeLabels() {
        return [
            'instansi'=>'Instansi',
            'tanggal'=>'Tanggal',
            'bulan'=>'Bulan'
        ];
    }
}