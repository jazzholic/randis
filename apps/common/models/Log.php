<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "log".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $username
 * @property string $nama
 * @property string $level
 * @property string $login
 * @property string $logout
 */
class Log extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'username', 'nama', 'level', 'login', 'logout'], 'required'],
            [['user_id'], 'integer'],
            [['login', 'logout'], 'safe'],
            [['username', 'nama', 'level'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'username' => 'Username',
            'nama' => 'Nama',
            'level' => 'Level',
            'login' => 'Last Login',
            'logout' => 'Logout',
        ];
    }
}