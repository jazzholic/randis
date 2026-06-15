<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "golongan".
 *
 * @property int $id
 * @property string $golongan
 * @property string $pangkat
 *
 * @property Pemegang[] $pemegangs
 */
class Golongan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'golongan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['golongan', 'pangkat'], 'required'],
            [['golongan'], 'string', 'max' => 5],
            [['pangkat'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'golongan' => 'Golongan',
            'pangkat' => 'Pangkat',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPemegangs()
    {
        return $this->hasMany(Pemegang::className(), ['golongan_id' => 'id']);
    }

    public function getGolpang()
    {
        return $this->golongan.' - '.$this->pangkat;
    }
}
