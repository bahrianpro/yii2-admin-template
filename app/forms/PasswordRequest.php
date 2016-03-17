<?php
/**
 * @author Skorobogatko Oleksii <skorobogatko.oleksii@gmail.com>
 * @copyright 2016
 * @version $Id$
 */

namespace app\forms;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * PasswordRequest
 *
 * @author skoro
 */
class PasswordRequest extends Model
{
    
    /**
     * @var string
     */
    public $email;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => Yii::$app->user->identityClass,
                'filter' => ['status' => User::STATUS_ENABLED],
                'message' => 'User with this email not found.',
            ],
        ];
    }
    
    /**
     * Send password reset instructions.
     * @return User|false
     */
    public function sendEmail()
    {
        $user = User::findByEmail($this->email);
        if ($user && $user->status === User::STATUS_ENABLED) {
            $user->generatePasswordResetToken();
            if ($user->save()) {
                
            }
        }
        
        return false;
    }
    
}
