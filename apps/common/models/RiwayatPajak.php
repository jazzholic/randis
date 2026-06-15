<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "riwayat_pajak".
 *
 * @property int $id_pajak
 * @property int $kendaraan_id
 * @property string $tanggal_bayar
 * @property string $tanggal_expired
 * @property int $instansi_id
 *
 * @property Kendaraan $kendaraan
 * @property Instansi $instansi
 */
class RiwayatPajak extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'riwayat_pajak';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kendaraan_id', 'tanggal_bayar', 'tanggal_expired', 'instansi_id'], 'required'],
            [['kendaraan_id', 'instansi_id','jumlah_bayar'], 'integer'],
            [['tanggal_bayar', 'tanggal_expired'], 'safe'],
            [['kendaraan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Kendaraan::className(), 'targetAttribute' => ['kendaraan_id' => 'id_kendaraan']],
            [['instansi_id'], 'exist', 'skipOnError' => true, 'targetClass' => Instansi::className(), 'targetAttribute' => ['instansi_id' => 'id_instansi']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_pajak' => 'Id Pajak',
            'kendaraan_id' => 'Kendaraan ID',
            'tanggal_bayar' => 'Tanggal Bayar',
            'tanggal_expired' => 'Tanggal Expired',
            'instansi_id' => 'Instansi ID',
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
    public function getInstansi()
    {
        return $this->hasOne(Instansi::className(), ['id_instansi' => 'instansi_id']);
    }
}
