<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "obat_masuk".
 *
 * @property string $kode_transaksi
 * @property string $tanggal_masuk
 * @property string $kode_obat
 * @property int $jumlah_masuk
 * @property int $created_user
 * @property string $created_date
 */
class ObatMasuk extends \yii\db\ActiveRecord
{
    public $nama_obat;
    public $stok;
    public $total_stok;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'obat_masuk';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_transaksi', 'tanggal_masuk', 'kode_obat', 'jumlah_masuk', 'created_user'], 'required'],
            [['tanggal_masuk', 'created_date'], 'safe'],
            [['jumlah_masuk', 'created_user'], 'integer'],
            [['kode_transaksi'], 'string', 'max' => 15],
            [['kode_obat'], 'string', 'max' => 7],
            [['kode_transaksi'], 'unique'],
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
            'jumlah_masuk' => 'Jumlah Masuk',
            'created_user' => 'Created User',
            'created_date' => 'Created Date',
        ];
    }

    public function getObat()
    {
        return $this->hasOne(Obat::className(), ['kode_obat' => 'kode_obat']);
    }
}
