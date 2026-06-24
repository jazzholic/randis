<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\Log;
use common\models\PasswordForm;
use common\models\User;
use common\models\Kendaraan;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'index'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'changepass'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    //public function actions()
    //{
        //$this->layout = 'error'; 

        //return [
            //'error' => [
                //'class' => 'yii\web\ErrorAction',
            //],
        //];
    //}

    //public function beforeAction($action)
    //{
        //if ($action->id == 'error') {
            //$this->layout = 'error';
        //}

        //return parent::beforeAction($action);
    //}

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            $statusCode = $exception->statusCode;
            $name = $exception->getName();
            $message = $exception->getMessage();
            
            // Handle Error 403 - Forbidden
            if ($statusCode == 403) {
                if (!Yii::$app->user->isGuest) {
                    Yii::$app->user->logout();
                }
                Yii::$app->session->setFlash('info', 'Akses ditolak. Silakan login kembali.');
                return $this->redirect(['login']);
            }
            
            // Jika user sudah login untuk error lain, redirect ke halaman admin/home
            if (!Yii::$app->user->isGuest && $statusCode != 403) {
                return $this->redirect(['index']);
            }
            
            $this->layout = 'error';
            
            return $this->render('error', [
                'exception' => $exception,
                'statusCode' => $statusCode,
                'name' => $name,
                'message' => $message
            ]);
        }
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) {
            if(Yii::$app->user->identity->level === 'pemegang'){

                $request = Yii::$app->request;

                $pemegang = \common\models\Pemegang::find()->where(['nip_pemegang'=>Yii::$app->user->identity->username])->one();
                
                if($pemegang === null) {
                    throw new \yii\web\NotFoundHttpException('Data pemegang tidak ditemukan.');
                }

                $model = \common\models\Kendaraan::find()->where(['pemegang_id'=>$pemegang['id_pemegang']])->one();
                
                if($model === null) {
                    throw new \yii\web\NotFoundHttpException('Data kendaraan tidak ditemukan.');
                }
                
                $model->setScenario('update'); 

                if($model->load($request->post()) && $model->save()){
                    Yii::$app->getSession()->setFlash('warning', ['title' => 'Data Kendaraan Berhasil di Perbaharui']);
                    return $this->redirect(['index']);
                }

                return $this->render('pemegang',['pemegang'=>$pemegang,'model'=>$model]);

            }elseif(Yii::$app->user->identity->level === 'instansi'){

                $instansi  = \common\models\Instansi::find()->select(['id_instansi' ])->where(['parent_id'=>Yii::$app->user->identity->instansi])->all();
                $a = [];
                foreach ($instansi as $key) {
                    $a[] = $key['id_instansi'];
                }

                $query = \common\models\Kendaraan::find()->where(['instansi_id'=>Yii::$app->user->identity->instansi])->orWhere(['in', 'instansi_id',$a])->orderBy([
                    'tahun_pembelian'=>SORT_ASC
                ]);
                $limit = 8;
                $countQuery = clone $query;
                $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize' => $limit]);
                $model = $query->offset($pages->offset)
                            ->limit($pages->limit)
                            ->all();
                return $this->render('index', [
                    'model' => $model,'pages'=>$pages
                ]);
            }else{
                $query = \common\models\Kendaraan::find()->orderBy([
                    'tahun_pembelian'=>SORT_ASC
                ]);
                $limit = 8;
                $countQuery = clone $query;
                $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize' => $limit]);
                $model = $query->offset($pages->offset)
                            ->limit($pages->limit)
                            ->all();
                return $this->render('index', [
                    'model' => $model,'pages'=>$pages
                ]);
            }
        }else{
            $this->layout = 'kendaraan';           

            return $this->render('kendaraan');           
        }
    }

    /**
     * Login action.
     *
     * @return string
     */
 
    public function beforeAction($action)
    {
        if (in_array($action->id, ['login', 'error'], true)) {
            Yii::$app->response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
            Yii::$app->response->headers->set('Pragma', 'no-cache');
            Yii::$app->response->headers->set('Expires', 'Thu, 01 Jan 1970 00:00:00 GMT');
        }

        return parent::beforeAction($action);
    }

    public function actionLogin()
    {
        $this->layout = 'login'; 
        
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $loging     = new Log();
            $loging->user_id    = Yii::$app->user->identity->id;
            $loging->username   = Yii::$app->user->identity->username;
            $loging->nama       = Yii::$app->user->identity->name;
            $loging->level      = Yii::$app->user->identity->level;
            $loging->login      = date('Y-m-d H:i:s');
            $loging->logout     = '0000-00-00 00:00:00';
            $loging->save();
            return $this->goBack();
        } else {
            $model->password = '';
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        $model = Log::find()->where(['user_id'=>Yii::$app->user->identity->id])->orderBy(['id' => SORT_DESC])->one();

        if($model !== null){
            if(count((array)$model)>0){
                $model->logout = date('Y-m-d H:i:s');        
                $model->update();
            }
        }


        $log = Log::find()->where(['user_id'=>Yii::$app->user->identity->id])->andWhere(['logout'=>'0000-00-00'])->orderBy(['id' => SORT_DESC])->all();
        foreach ($log as $key) {
            Log::findOne($key->id)->delete();
        }

        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionChangepass()
    {
        $model      = new PasswordForm;
        $modeluser  = User::find()->where(['username'=>Yii::$app->user->identity->username])->one();
        if($model->load(Yii::$app->request->post()))
        {
            if($model->validate())
            {
                try
                {
                    $modeluser->password_hash = Yii::$app->security->generatePasswordHash($_POST['PasswordForm']['newpass']);
                    if($modeluser->save())
                    {
                        Yii::$app->user->logout();
                        Yii::$app->getSession()->setFlash(
                        'success','Password Berhasil di Rubah'
                        );
                       return $this->redirect(['index']);
                    }
                    else
                    {
                        Yii::$app->getSession()->setFlash(
                        'error','Password Gagal di Rubah'
                        );
                       return $this->redirect(['index']);
                    }
                }
                catch(Exception $e)
                {
                    Yii::$app->getSession()->setFlash(
                    'error',"{$e->getMessage()}"
                    );
                   return $this->render('changepassword',[
                    'model'=>$model
                    ]);
                }
            }
            else
            {
               return $this->render('changepassword',[
                'model'=>$model
                ]);
            }
        }
        else
        {
            return $this->render('changepassword',[
            'model'=>$model
            ]);
        }
    }
}
