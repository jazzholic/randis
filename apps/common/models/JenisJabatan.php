<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "jenis_jabatan".
 *
 * @property int $id_jabatan
 * @property string $nama_jabatan
 */
class JenisJabatan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jenis_jabatan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_jabatan'], 'required'],
            [['nama_jabatan'], 'string', 'max' => 225],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_jabatan' => 'Id Jabatan',
            'nama_jabatan' => 'Nama Jabatan',
        ];
    }
}
