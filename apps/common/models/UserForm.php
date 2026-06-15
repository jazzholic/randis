<?php
namespace common\models;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class UserForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $level;
    public $name;
    public $instansi;
    public $bidang;
    public $tempat_lahir;
    public $tanggal_lahir;
    public $no_telp;
    public $skpd;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['username', 'match', 'not' => true, 'pattern' => '/[^a-z0-9_]/', 'message' => 'Invalid characters Username, Only a-z_0-9 are Allowed and space not allowed', ],

            //[['statusrayon'], 'validateRayon'],
            
            //['statusrayon', 'compare', 'compareValue' => 0, 'operator' => '>', 'message' => 'Your password should contain atleast one number and one special character and it should be minimum 6'],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            //['reCaptcha', \himiklab\yii2\recaptcha\ReCaptchaValidator::className(), 'secret' => '6LctGh8UAAAAAJJ0-OtQHWM3ZS7hweBaD9FeUOF2', 'uncheckedMessage' => 'Please confirm that you are not a bot.']
            ['name', 'required'],
            ['name', 'string', 'max' => 100],
            //['no_telp', 'string', 'max' => 100],
            ['level', 'required'],
            ['level', 'string', 'max' => 100],

            ['instansi', 'required'],
            //['bidang', 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'skpd' => 'Nama Instansi',
            'name' => 'Nama Lengkap',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email    = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->level    = $this->level;
        $user->name     = $this->name;
        $user->instansi = $this->instansi;
        //$user->no_telp  = $this->no_telp;
        
        return $user->save() ? $user : null;
    }
}