<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "obat".
 *
 * @property string $kode_obat
 * @property string $nama_obat
 * @property int $harga_beli
 * @property int $harga_jual
 * @property string $satuan
 * @property int $stok
 * @property int $created_user
 * @property string $created_date
 * @property int $updated_user
 * @property string $updated_date
 */
class Obat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'obat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_obat', 'harga_beli', 'harga_jual', 'satuan', 'stok', 'created_user', 'updated_user'], 'required'],
            [['harga_beli', 'harga_jual', 'stok', 'created_user', 'updated_user'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['kode_obat'], 'string', 'max' => 7],
            [['nama_obat'], 'string', 'max' => 50],
            [['satuan'], 'string', 'max' => 20],
            [['kode_obat'], 'unique'],
            [['kode_obat'], 'autonumber',
            'format' => function(){
                return 'B?';
            }
            , 'digit' => 6],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kode_obat' => 'Kode Obat',
            'nama_obat' => 'Nama Obat',
            'harga_beli' => 'Harga Beli',
            'harga_jual' => 'Harga Jual',
            'satuan' => 'Satuan',
            'stok' => 'Stok',
            'created_user' => 'Created User',
            'created_date' => 'Created Date',
            'updated_user' => 'Updated User',
            'updated_date' => 'Updated Date',
        ];
    }

    public function getFull(){
        return $this->kode_obat.' | '.$this->nama_obat;
    }
}
