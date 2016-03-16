<?php
/**
 * @author Skorobogatko Alexei <skorobogatko.alexei@gmail.com>
 * @copyright 2016
 * @version $Id$
 */

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\base\Controller;
use app\forms;

/**
 * UserController
 * 
 * @author skoro
 */
class UserController extends Controller
{
    
    public $layout = '//main-login';
    
    /**
     * @var boolean enable or disable user registration.
     */
    public $enableRegister = true;
    
    /**
     * @return inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['login', 'register'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }
    
    /**
     * user/login
     */
    public function actionLogin()
    {
        $model = new forms\Login();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        
        return $this->render('login', [
            'model' => $model,
            'enableRegister' => $this->enableRegister,
        ]);
    }
    
    /**
     * user/register
     */
    public function actionRegister()
    {
        if (!$this->enableRegister) {
            return $this->goHome();
        }
        
        $model = new forms\Register();
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->load($post) && $model->register()) {
                return $this->goHome();
            }
        }
        
        return $this->render('register', [
            'model' => $model,
        ]);
    }

    /**
     * user/logout
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

}
