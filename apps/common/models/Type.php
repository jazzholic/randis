<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "type".
 *
 * @property int $id_type
 * @property int $jenis_id
 * @property int $merk_id
 * @property string $nama_type
 *
 * @property Kendaraan[] $kendaraans
 * @property JenisBarang $jenis
 * @property Merk $merk
 */
class Type extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jenis_id', 'merk_id', 'nama_type'], 'required'],
            [['jenis_id', 'merk_id'], 'integer'],
            [['nama_type'], 'string', 'max' => 100],
            [['jenis_id'], 'exist', 'skipOnError' => true, 'targetClass' => JenisBarang::className(), 'targetAttribute' => ['jenis_id' => 'id_jenis_barang']],
            [['merk_id'], 'exist', 'skipOnError' => true, 'targetClass' => Merk::className(), 'targetAttribute' => ['merk_id' => 'id_merek']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_type' => 'Id Type',
            'jenis_id' => 'Jenis ID',
            'merk_id' => 'Merk ID',
            'nama_type' => 'Nama Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKendaraans()
    {
        return $this->hasMany(Kendaraan::className(), ['type_id' => 'id_type']);
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
    public function getMerk()
    {
        return $this->hasOne(Merk::className(), ['id_merek' => 'merk_id']);
    }

    public static function getTypeList($id)
    {
        $data= self::find()
            ->where(['merk_id'=>$id])
            ->select(['id_type AS id','nama_type AS name' ])->asArray()->all();

        return $data;
    }

    public static function getProdList($jenis_id, $merk_id)
    {
        $data= self::find()
            ->where(['jenis_id'=>$jenis_id])
            ->andWhere(['merk_id'=>$merk_id])
            ->select(['id_type AS id','nama_type AS name' ])->asArray()->all();

        return $data;
    }
}
