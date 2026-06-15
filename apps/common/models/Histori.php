<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "histori".
 *
 * @property int $id
 * @property int $kendaraan_id
 * @property string $nopol_awal
 * @property int $nopol_akhir
 * @property string $nama_pemegang
 * @property string $tanggal
 * @property int $instansi_id
 */
class Histori extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'histori';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kendaraan_id', 'nopol_awal', 'nopol_akhir', 'nama_pemegang', 'tanggal', 'instansi_id'], 'required'],
            [['kendaraan_id', 'instansi_id'], 'integer'],
            [['tanggal','keterangan'], 'safe'],
            [['nopol_awal','nopol_akhir'], 'string', 'max' => 15],
            [['nama_pemegang'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kendaraan_id' => 'Kendaraan',
            'nopol_awal' => 'Nomor Polisi Lama',
            'nopol_akhir' => 'Nomor Polisi Baru',
            'nama_pemegang' => 'Nama Pemegang',
            'tanggal' => 'Tanggal Berubah',
            'instansi_id' => 'Instansi ID',
        ];
    }

    public function getKendaraan()
    {
        return $this->hasOne(Kendaraan::className(), ['id_kendaraan' => 'kendaraan_id']);
    }

    public function getInstansi()
    {
        return $this->hasOne(Instansi::className(), ['id_instansi' => 'instansi_id']);
    }
}
