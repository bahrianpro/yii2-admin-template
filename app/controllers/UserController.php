<?php
/**
 * @author Skorobogatko Oleksii <skorobogatko.oleksii@gmail.com>
 * @copyright 2016
 * @version $Id$
 */

namespace app\controllers;

use app\base\actions\user;
use app\base\Controller;
use app\forms\user\Register;
use app\models\User as UserModel;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * UserController
 * 
 * @author skoro
 */
class UserController extends Controller
{
    
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'profile' => [
                'class' => user\Profile::className(),
                'layout' => '//main',
            ],
            'login' => [
                'class' => user\Login::className(),
                'layout' => '//main-login',
            ],
            'logout' => [
                'class' => user\Logout::className(),
            ],
            'register' => [
                'class' => user\Register::className(),
                'layout' => '//main-login',
            ],
            'password-request' => [
                'class' => user\PasswordRequest::className(),
                'layout' => '//main-login',
            ],
            'password-reset' => [
                'class' => user\PasswordReset::className(),
                'layout' => '//main-login',
            ],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['viewAnyUser'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['deleteAnyUser'],
                    ],
                    [
                        'actions' => ['profile', 'logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['login', 'register', 'password-request',
                            'password-reset'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }
    
    /**
     * Users list.
     * @since 0.2
     */
    public function actionIndex()
    {
        $userProvider = new ActiveDataProvider([
            'query' => UserModel::find(),
        ]);
        
        $register = new Register();
        $register->setScenario('admin');
        
        $request = Yii::$app->request;
        if (Yii::$app->user->can('createUser') && $request->isPost && 
                $register->load($request->post())) {
            if ($request->isAjax && !$request->isPjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($register);
            }
            if ($user = $register->register()) {
                $this->addFlash(self::FLASH_SUCCESS, t('User <b>{name}</b> created.', [
                    'name' => e($user->name),
                ]));
            }
        }
        
        return $this->render('index', [
            'userProvider' => $userProvider,
            'register' => $register,
        ]);
    }
    
    /**
     * Delete user action.
     * @param integer $id user id
     * @since 0.2
     */
    public function actionDelete($id)
    {
        /** @var $user UserModel */
        $user = $this->findModel(UserModel::className(), $id);
        if ($user->delete()) {
            $this->addFlash(self::FLASH_SUCCESS, t('User <b>{name}</b> deleted.', [
                'name' => e($user->name),
            ]));
        }
        
        return $this->redirect(['index']);
    }
}
