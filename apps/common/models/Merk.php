<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "merk".
 *
 * @property int $id_merek
 * @property int $jenis_id
 * @property string $nama_merk
 *
 * @property Kendaraan[] $kendaraans
 * @property JenisBarang $jenis
 * @property Type[] $types
 */
class Merk extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'merk';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jenis_id', 'nama_merk'], 'required'],
            [['jenis_id'], 'integer'],
            [['nama_merk'], 'string', 'max' => 100],
            [['jenis_id'], 'exist', 'skipOnError' => true, 'targetClass' => JenisBarang::className(), 'targetAttribute' => ['jenis_id' => 'id_jenis_barang']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_merek' => 'Id Merek',
            'jenis_id' => 'Jenis',
            'nama_merk' => 'Nama Merk',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKendaraans()
    {
        return $this->hasMany(Kendaraan::className(), ['merk_id' => 'id_merek']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJenis()
    {
        return $this->hasOne(JenisBarang::className(), ['id_jenis_barang' => 'jenis_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypes()
    {
        return $this->hasMany(Type::className(), ['merk_id' => 'id_merek']);
    }

    public static function getMerkList($id)
    {
        $data= self::find()
            ->where(['jenis_id'=>$id])
            ->select(['id_merek AS id','nama_merk AS name' ])->asArray()->all();

        return $data;
    }
}
