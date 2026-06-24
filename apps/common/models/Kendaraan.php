<?php

namespace common\models;

use Yii;
use mongosoft\file\UploadBehavior; 

/**
 * This is the model class for table "kendaraan".
 *
 * @property int $id_kendaraan
 * @property int $jenis_id
 * @property int $merk_id
 * @property int $type_id
 * @property int $isi_silinder
 * @property int $tahun_pembelian
 * @property string $nomor_rangka
 * @property string $nomor_mesin
 * @property string $nomo_polisi
 * @property string $nomor_bpkb
 * @property int $pemegang_id
 * @property int $kondisi_id
 * @property string $harga_pembelian
 * @property string $pagu_perawatan
 * @property string $tampak_depan
 * @property string $tampak_belakang
 * @property string $tampak_samping_r
 * @property string $tampak_samping_l
 * @property int $instansi_id
 *
 * @property JenisBarang $jenis
 * @property Merk $merk
 * @property Type $type
 * @property Kondisi $kondisi
 * @property Instansi $instansi
 * @property Perawatan[] $perawatans
 * @property RiwayatPajak[] $riwayatPajaks
 */
class Kendaraan extends \yii\db\ActiveRecord
{
    public $nomor_polisi_lama;
    public $pemegang_lama;
    public $instansi_lama;

    public function behaviors()
    {
        return [
            [
                'class' => UploadBehavior::className(),
                'attribute' => 'tampak_depan',
                'scenarios' => ['insert', 'update'],
                'path' => '@webfront/img/kendaraan/f',
                'url' => '@webfront/img/kendaraan/f',
            ],
            [
                'class' => UploadBehavior::className(),
                'attribute' => 'tampak_belakang',
                'scenarios' => ['insert', 'update'],
                'path' => '@webfront/img/kendaraan/b',
                'url' => '@webfront/img/kendaraan/b',
            ],
            [
                'class' => UploadBehavior::className(),
                'attribute' => 'tampak_samping_r',
                'scenarios' => ['insert', 'update'],
                'path' => '@webfront/img/kendaraan/r',
                'url' => '@webfront/img/kendaraan/r',
            ],
            [
                'class' => UploadBehavior::className(),
                'attribute' => 'tampak_samping_l',
                'scenarios' => ['insert', 'update'],
                'path' => '@webfront/img/kendaraan/l',
                'url' => '@webfront/img/kendaraan/l',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kendaraan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jenis_id', 'merk_id', 'type_id', 'isi_silinder', 'tahun_pembelian', 'nomor_rangka', 'nomor_mesin', 'nomor_polisi', 'nomor_bpkb', 'pemegang_id', 'kondisi_id'], 'required'],
            [['jenis_id', 'merk_id', 'type_id', 'isi_silinder', 'tahun_pembelian', 'pemegang_id', 'pemegang_lama', 'kondisi_id', 'harga_pembelian', 'pagu_perawatan', 'instansi_id','instansi_lama'], 'integer'],
            [['nomor_rangka', 'nomor_mesin', 'nomor_polisi', 'nomor_polisi_lama', 'nomor_bpkb'], 'string', 'max' => 50],
            [['keterangan','merk_type'], 'string', 'max' => 225],
            [['jenis_id'], 'exist', 'skipOnError' => true, 'targetClass' => JenisBarang::className(), 'targetAttribute' => ['jenis_id' => 'id_jenis_barang']],
            [['merk_id'], 'exist', 'skipOnError' => true, 'targetClass' => Merk::className(), 'targetAttribute' => ['merk_id' => 'id_merek']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => Type::className(), 'targetAttribute' => ['type_id' => 'id_type']],
            [['kondisi_id'], 'exist', 'skipOnError' => true, 'targetClass' => Kondisi::className(), 'targetAttribute' => ['kondisi_id' => 'id_kondisi']],
            [['instansi_id'], 'exist', 'skipOnError' => true, 'targetClass' => Instansi::className(), 'targetAttribute' => ['instansi_id' => 'id_instansi']],
            //[['tampak_depan', 'tampak_belakang', 'tampak_samping_r', 'tampak_samping_l'],'required','on' => 'insert'],
            [['tampak_depan', 'tampak_belakang', 'tampak_samping_r', 'tampak_samping_l'],'file','extensions'=>'jpg, jpeg, png', 'maxSize'=>1024 * 1024 * 1,'on' => ['insert', 'update']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_kendaraan' => 'ID',
            'jenis_id' => 'Jenis',
            'merk_id' => 'Merk',
            'type_id' => 'Type',
            'isi_silinder' => 'Isi Silinder',
            'tahun_pembelian' => 'Tahun Pembelian',
            'nomor_rangka' => 'Nomor Rangka',
            'nomor_mesin' => 'Nomor Mesin',
            'nomor_polisi' => 'Nomor Polisi',
            'nomor_bpkb' => 'Nomor BPKB',
            'pemegang_id' => 'Pemegang',
            'kondisi_id' => 'Kondisi',
            'harga_pembelian' => 'Harga Pembelian',
            'pagu_perawatan' => 'Pagu Perawatan',
            'tampak_depan' => 'Tampak Depan',
            'tampak_belakang' => 'Tampak Belakang',
            'tampak_samping_r' => 'Tampak Samping R',
            'tampak_samping_l' => 'Tampak Samping L',
            'instansi_id' => 'Instansi',
        ];
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(Type::className(), ['id_type' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKondisi()
    {
        return $this->hasOne(Kondisi::className(), ['id_kondisi' => 'kondisi_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstansi()
    {
        return $this->hasOne(Instansi::className(), ['id_instansi' => 'instansi_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerawatans()
    {
        return $this->hasMany(Perawatan::className(), ['kendaraan_id' => 'id_kendaraan']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRiwayatPajaks()
    {
        return $this->hasMany(RiwayatPajak::className(), ['kendaraan_id' => 'id_kendaraan']);
    }

    public function getPemegang()
    {
        return $this->hasOne(Pemegang::className(), ['id_pemegang' => 'pemegang_id']);
    }

    public function getNopol()
    {
        return $this->nomor_polisi.' - '.$this->nomor_mesin;
    }

    public function getKendaraan()
    {
        $pemegang = \common\models\Pemegang::find()->where(['id_pemegang'=>$this->pemegang_id])->one();
        $namaPemegang = $pemegang ? $pemegang['nama_pemegang'] : '-';

        return $this->nomor_polisi.' - '.$namaPemegang;
    }
}
