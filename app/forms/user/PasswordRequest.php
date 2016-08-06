<?php
/**
 * @author Skorobogatko Oleksii <skorobogatko.oleksii@gmail.com>
 * @copyright 2016
 * @version $Id$
 */

namespace app\forms\user;

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
     * @return boolean
     */
    public function sendEmail()
    {
        $user = User::findByEmail($this->email);
        if ($user && $user->status === User::STATUS_ENABLED) {
            $user->generatePasswordResetToken();
            if ($user->save()) {
                return Yii::$app->mailer->compose(
                            [
                                'html' => 'passwordRequest-html',
                                'text' => 'passwordRequest-text'
                            ],
                            ['user' => $user])
                        ->setFrom(Yii::$app->params['adminEmail'])
                        ->setTo($this->email)
                        ->setSubject(Yii::t('app', 'Reset password information for {name} at {site}', ['name' => $user->name, 'site' => Yii::$app->name]))
                        ->send();
            }
        }
        
        return false;
    }
    
}
