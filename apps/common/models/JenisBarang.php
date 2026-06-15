<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "jenis_barang".
 *
 * @property int $id_jenis_barang
 * @property string $jenis_barang
 *
 * @property Kendaraan[] $kendaraans
 * @property Merk[] $merks
 * @property Type[] $types
 */
class JenisBarang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jenis_barang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jenis_barang'], 'required'],
            [['jenis_barang'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_jenis_barang' => 'ID Jenis Barang',
            'jenis_barang' => 'Jenis Barang',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKendaraans()
    {
        return $this->hasMany(Kendaraan::className(), ['jenis_id' => 'id_jenis_barang']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMerks()
    {
        return $this->hasMany(Merk::className(), ['jenis_id' => 'id_jenis_barang']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypes()
    {
        return $this->hasMany(Type::className(), ['jenis_id' => 'id_jenis_barang']);
    }
}
