<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "instansi".
 *
 * @property int $id_instansi
 * @property string $nama_instansi
 * @property string $alamat
 * @property string $telp
 * @property string $fax
 * @property string $email
 *
 * @property Kendaraan[] $kendaraans
 * @property Pemegang[] $pemegangs
 * @property Perawatan[] $perawatans
 * @property RiwayatPajak[] $riwayatPajaks
 */
class Instansi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'instansi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_instansi', 'alamat', 'telp', 'fax', 'email'], 'required'],
            [['alamat','parent_id'], 'string'],
            [['parent_id'], 'integer'],
            [['nama_instansi'], 'string', 'max' => 150],
            [['telp', 'fax', 'email'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_instansi' => 'Id Instansi',
            'nama_instansi' => 'Nama Instansi',
            'alamat' => 'Alamat',
            'telp' => 'Telp',
            'fax' => 'Fax',
            'email' => 'Email',
            'parent_id' => 'Parent Instansi'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKendaraans()
    {
        return $this->hasMany(Kendaraan::className(), ['instansi_id' => 'id_instansi']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPemegangs()
    {
        return $this->hasMany(Pemegang::className(), ['instansi_id' => 'id_instansi']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerawatans()
    {
        return $this->hasMany(Perawatan::className(), ['instansi_id' => 'id_instansi']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRiwayatPajaks()
    {
        return $this->hasMany(RiwayatPajak::className(), ['instansi_id' => 'id_instansi']);
    }

    public function getInstansis()
    {
        return $this->hasMany(User::className(), ['instansi' => 'id_instansi']);
    }

    public function getParent()
    {
        return $this->hasOne(Instansi::className(), ['parent_id' => 'id_instansi']);
    }
}
