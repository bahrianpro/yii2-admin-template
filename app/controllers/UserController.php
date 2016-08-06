<?php
/**
 * @author Skorobogatko Oleksii <skorobogatko.oleksii@gmail.com>
 * @copyright 2016
 * @version $Id$
 */

namespace app\controllers;

use app\base\actions\user;
use app\base\Controller;
use yii\filters\AccessControl;

/**
 * UserController
 * 
 * @author skoro
 */
class UserController extends Controller
{
    
    /**
     * @var string views layout.
     */
    public $layout = '//main-login';
    
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
            ],
            'logout' => [
                'class' => user\Logout::className(),
            ],
            'register' => [
                'class' => user\Register::className(),
            ],
            'password-request' => [
                'class' => user\PasswordRequest::className(),
            ],
            'password-reset' => [
                'class' => user\PasswordReset::className(),
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
}
