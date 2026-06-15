<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "obat_keluar".
 *
 * @property string $kode_transaksi
 * @property string $tanggal_masuk
 * @property string $kode_obat
 * @property int $jumlah_keluar
 * @property int $created_user
 * @property string $created_date
 */
class ObatKeluar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'obat_keluar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tanggal_masuk', 'kode_obat', 'jumlah_keluar', 'created_user'], 'required'],
            [['tanggal_masuk', 'created_date'], 'safe'],
            [['jumlah_keluar', 'created_user'], 'integer'],
            [['kode_transaksi'], 'string', 'max' => 15],
            [['kode_obat'], 'string', 'max' => 7],
            [['kode_transaksi'], 'unique'],
            [['kode_transaksi'], 'autonumber',
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
            'kode_transaksi' => 'Kode Transaksi',
            'tanggal_masuk' => 'Tanggal Masuk',
            'kode_obat' => 'Kode Obat',
            'jumlah_keluar' => 'Jumlah Keluar',
            'created_user' => 'Created User',
            'created_date' => 'Created Date',
        ];
    }
}
