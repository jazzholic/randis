<?php

namespace common\models;

use Yii;
use mongosoft\file\UploadImageBehavior;

/**
 * This is the model class for table "pemegang".
 *
 * @property int $id_pemegang
 * @property string $nama_pemegang
 * @property string $nip_pemegang
 * @property int $golongan_id
 * @property string $jenis_kelamin
 * @property string $email
 * @property string $jabatan
 * @property string $alamat
 * @property string $no_telp
 * @property int $instansi_id
 * @property string $namafile
 *
 * @property Golongan $golongan
 * @property Instansi $instansi
 */
class Pemegang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pemegang';
    }

    function behaviors()
    {
        return [
            [
                'class' => UploadImageBehavior::className(),
                'attribute' => 'namafile',
                'scenarios' => ['insert', 'update'],
                'placeholder' => '@app/modules/user/assets/images/userpic.jpg',
                'path' => '@webfront/img/pemegang',
                'url' => '@webfront/img/pemegang',
                'thumbs' => [
                      'thumb' => ['width' => 200, 'quality' => 90]
                 ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_pemegang', 'nip_pemegang', 'golongan_id', 'jenis_kelamin', 'email', 'jabatan', 'alamat', 'no_telp', 'instansi_id'], 'required'],
            [['nip_pemegang', 'golongan_id', 'instansi_id'], 'integer'],
            [['jenis_kelamin', 'alamat'], 'string'],
            [['nama_pemegang'], 'string', 'max' => 100],
            [['email', 'no_telp'], 'string', 'max' => 50],
            [['jabatan'], 'string', 'max' => 200],
            ['email', 'email'],
            [['golongan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Golongan::className(), 'targetAttribute' => ['golongan_id' => 'id']],
            [['instansi_id'], 'exist', 'skipOnError' => true, 'targetClass' => Instansi::className(), 'targetAttribute' => ['instansi_id' => 'id_instansi']],
            [['namafile'],'required','on' => 'insert'],
            [['namafile'],'file','extensions'=>'jpg, jpeg, png', 'maxSize'=>1024 * 1024 * 1,'on' => ['update', 'insert']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_pemegang' => 'ID',
            'nama_pemegang' => 'Nama Pemegang',
            'nip_pemegang' => 'NIP',
            'golongan_id' => 'Pangkat/Golongan',
            'jenis_kelamin' => 'Jenis Kelamin',
            'email' => 'Email',
            'jabatan' => 'Jabatan',
            'alamat' => 'Alamat',
            'no_telp' => 'No. Telp',
            'instansi_id' => 'Instansi ID',
            'namafile' => 'Namafile',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGolongan()
    {
        return $this->hasOne(Golongan::className(), ['id' => 'golongan_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstansi()
    {
        return $this->hasOne(Instansi::className(), ['id_instansi' => 'instansi_id']);
    }
}
