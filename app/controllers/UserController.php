<?php
/**
 * @author Skorobogatko Oleksii <skorobogatko.oleksii@gmail.com>
 * @copyright 2016
 * @version $Id$
 */

namespace app\controllers;

use Yii;
use app\base\Controller;

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
            'login' => [
                'class' => 'app\base\actions\user\Login',
            ],
            'logout' => [
                'class' => 'app\base\actions\user\Logout',
            ],
            'register' => [
                'class' => 'app\base\actions\user\Register',
            ],
            'password-request' => [
                'class' => 'app\base\actions\user\PasswordRequest',
            ],
        ];
    }
    
}
