<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "is_users".
 *
 * @property int $id_user
 * @property string $username
 * @property string $nama_user
 * @property string $password
 * @property string $email
 * @property string $telepon
 * @property string $foto
 * @property string $hak_akses
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 */
class IsUsers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'is_users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'nama_user', 'password', 'hak_akses'], 'required'],
            [['hak_akses', 'status'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['username', 'nama_user', 'password', 'email'], 'string', 'max' => 50],
            [['telepon'], 'string', 'max' => 13],
            [['foto'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_user' => 'Id User',
            'username' => 'Username',
            'nama_user' => 'Nama User',
            'password' => 'Password',
            'email' => 'Email',
            'telepon' => 'Telepon',
            'foto' => 'Foto',
            'hak_akses' => 'Hak Akses',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
