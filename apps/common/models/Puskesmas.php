<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "puskesmas".
 *
 * @property string $kode_puskesmas
 * @property string $nama_puskesmas
 * @property string $alamat
 * @property string $no_telp
 * @property string $jenis_puskesmas
 * @property string $status_poned
 */
class Puskesmas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'puskesmas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_puskesmas', 'nama_puskesmas', 'alamat', 'no_telp', 'jenis_puskesmas', 'status_poned'], 'required'],
            [['jenis_puskesmas', 'status_poned'], 'string'],
            [['kode_puskesmas'], 'string', 'max' => 11],
            [['nama_puskesmas', 'alamat'], 'string', 'max' => 100],
            [['no_telp'], 'string', 'max' => 50],
            [['kode_puskesmas'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kode_puskesmas' => 'Kode Puskesmas',
            'nama_puskesmas' => 'Nama Puskesmas',
            'alamat' => 'Alamat',
            'no_telp' => 'No. Telp',
            'jenis_puskesmas' => 'Jenis Puskesmas',
            'status_poned' => 'Status Poned',
        ];
    }
}
