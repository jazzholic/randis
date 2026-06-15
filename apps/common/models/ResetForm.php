<?php 

    namespace common\models;

    use Yii;
    use yii\base\Model;
    use common\models\User;
        
    class ResetForm extends Model
    {
        public $newpass;
        public $name;
        public $username;
        
        public function rules()
        {
            return [
                [['newpass'],'required'],
                //['repeatnewpass','compare','compareAttribute'=>'newpass'],
            ];
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