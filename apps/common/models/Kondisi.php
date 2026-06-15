<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "kondisi".
 *
 * @property int $id_kondisi
 * @property string $kondisi
 *
 * @property Kendaraan[] $kendaraans
 */
class Kondisi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kondisi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kondisi'], 'required'],
            [['kondisi'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_kondisi' => 'Id Kondisi',
            'kondisi' => 'Kondisi',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKendaraans()
    {
        return $this->hasMany(Kendaraan::className(), ['kondisi_id' => 'id_kondisi']);
    }
}
