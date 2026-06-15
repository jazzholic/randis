<?php

namespace common\models;

use Yii;
use mongosoft\file\UploadBehavior;

/**
 * This is the model class for table "perawatan".
 *
 * @property int $id_perawatan
 * @property int $kendaraan_id
 * @property string $tanggal
 * @property string $rekanan
 * @property int $bbm_id
 * @property int $jumlah_liter
 * @property int $jumlah_kilometer
 * @property string $total_biaya
 * @property string $keterangan
 * @property string $lampiran
 * @property int $instansi_id
 *
 * @property Kendaraan $kendaraan
 * @property JenisBbm $bbm
 * @property Instansi $instansi
 */
class Perawatan extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => UploadBehavior::className(),
                'attribute' => 'lampiran',
                'scenarios' => ['insert', 'update'],
                'path' => '@webfront/img/perawatan',
                'url' => '@webfront/img/perawatan',
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'perawatan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kendaraan_id', 'tanggal', 'rekanan', 'bbm_id', 'jumlah_liter', 'jumlah_kilometer', 'total_biaya', 'instansi_id'], 'required'],
            [['kendaraan_id', 'bbm_id', 'jumlah_liter', 'jumlah_kilometer', 'total_biaya', 'instansi_id'], 'integer'],
            [['tanggal'], 'safe'],
            [['keterangan'], 'string'],
            [['rekanan'], 'string', 'max' => 100],
            [['lampiran'], 'string', 'max' => 225],
            [['kendaraan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Kendaraan::className(), 'targetAttribute' => ['kendaraan_id' => 'id_kendaraan']],
            [['bbm_id'], 'exist', 'skipOnError' => true, 'targetClass' => JenisBbm::className(), 'targetAttribute' => ['bbm_id' => 'id_bbm']],
            [['instansi_id'], 'exist', 'skipOnError' => true, 'targetClass' => Instansi::className(), 'targetAttribute' => ['instansi_id' => 'id_instansi']],
            [['lampiran'],'file','extensions'=>'jpg, jpeg, png', 'maxSize'=>1024 * 1024 * 1,'on' => ['insert', 'update']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_perawatan' => 'ID',
            'kendaraan_id' => 'Kendaraan',
            'tanggal' => 'Tanggal',
            'rekanan' => 'Rekanan',
            'bbm_id' => 'Jenis BBM',
            'jumlah_liter' => 'Jumlah Liter',
            'jumlah_kilometer' => 'Jumlah Kilometer',
            'total_biaya' => 'Total Biaya',
            'keterangan' => 'Keterangan',
            'lampiran' => 'Lampiran',
            'instansi_id' => 'Instansi',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKendaraan()
    {
        return $this->hasOne(Kendaraan::className(), ['id_kendaraan' => 'kendaraan_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBbm()
    {
        return $this->hasOne(JenisBbm::className(), ['id_bbm' => 'bbm_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstansi()
    {
        return $this->hasOne(Instansi::className(), ['id_instansi' => 'instansi_id']);
    }
}
