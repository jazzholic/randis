<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "jenis_bbm".
 *
 * @property int $id_bbm
 * @property string $jenis_bbm
 *
 * @property Perawatan[] $perawatans
 */
class JenisBbm extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jenis_bbm';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jenis_bbm'], 'required'],
            [['jenis_bbm'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_bbm' => 'ID BBM',
            'jenis_bbm' => 'Jenis BBM',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerawatans()
    {
        return $this->hasMany(Perawatan::className(), ['bbm_id' => 'id_bbm']);
    }
}
