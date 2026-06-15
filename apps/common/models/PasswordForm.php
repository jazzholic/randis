<?php 

    namespace common\models;

    use Yii;
    use yii\base\Model;
    use common\models\User;
        
    class PasswordForm extends Model
    {
        public $oldpass;
        public $newpass;
        public $repeatnewpass;
        //public $reCaptcha;
        
        public function rules()
        {
            return [
                [['oldpass','newpass','repeatnewpass'],'required'],
                ['oldpass','findPasswords'],
                ['newpass', 'match', 'pattern' => '/^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,16}$/', 'message' => 'Your password should contain atleast one number and one special character and it should be minimum 6'],
                ['repeatnewpass', 'match', 'pattern' => '/^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,16}$/', 'message' => 'Your password should contain atleast one number and one special character and it should be minimum 6'],
               // ['newpass','string','min' => 6],
                ['repeatnewpass','compare','compareAttribute'=>'newpass'],
                //['reCaptcha', \himiklab\yii2\recaptcha\ReCaptchaValidator::className(), 'secret' => '6LctGh8UAAAAAJJ0-OtQHWM3ZS7hweBaD9FeUOF2', 'uncheckedMessage' => 'Please confirm that you are not a bot.']
            ];
        }
        
        public function findPasswords($attribute, $params)
        {
            $user = User::find()->where([
                'username'=>Yii::$app->user->identity->username
            ])->one();
             $password = $user->password_hash;
            if(!Yii::$app->security->validatePassword($this->oldpass, $password))
                $this->addError($attribute,'Password Lama Salah.');
        }
        
        public function attributeLabels()
        {
            return [
                'oldpass'=>'Password Lama',
                'newpass'=>'Password Baru',
                'repeatnewpass'=>'Ulangi Password Baru',
            ];
        }
    }