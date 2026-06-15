<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pejabat".
 *
 * @property int $id_jabatan
 * @property int $jenis_jabatan
 * @property string $nama_pejabat
 * @property string $nip_pejabat
 * @property int $instansi_id
 */
class Pejabat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pejabat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jenis_jabatan', 'nama_pejabat', 'nip_pejabat', 'instansi_id'], 'required'],
            [['jenis_jabatan', 'nip_pejabat', 'instansi_id'], 'integer'],
            [['nama_pejabat'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_jabatan' => 'Id Jabatan',
            'jenis_jabatan' => 'Jenis Jabatan',
            'nama_pejabat' => 'Nama Pejabat',
            'nip_pejabat' => 'NIP Pejabat',
            'instansi_id' => 'Instansi',
        ];
    }

    public function getInstansi()
    {
        return $this->hasOne(Instansi::className(), ['id_instansi' => 'instansi_id']);
    }

    public function getJabatan()
    {
        return $this->hasOne(JenisJabatan::className(), ['id_jabatan' => 'jenis_jabatan']);
    }
}
