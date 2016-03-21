<?php
/**
 * @author Skorobogatko Oleksii <skorobogatko.oleksii@gmail.com>
 * @copyright 2016
 * @version $Id$
 */

namespace app\forms;

use Yii;
use yii\base\Model;
use yii\web\UserEvent;
use app\models\User;

/**
 * User register form.
 *
 * @author skoro
 */
class Register extends Model
{
    
    const EVENT_REGISTER = 'userRegister';

    /**
     * @var string
     */
    public $name;
    
    /**
     * @var string
     */
    public $email;
    
    /**
     * @var string
     */
    public $password;
    
    /**
     * @var string
     */
    public $password_repeat;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'filter', 'filter' => 'trim'],
            ['name', 'required'],
            ['name', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'compare'],
            ['password', 'string', 'min' => 6, 'max' => 64],
            
            ['password_repeat', 'required'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'User name'),
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Password'),
            'password_repeat' => Yii::t('app', 'Confirm password'),
        ];
    }

    /**
     * Register a new user.
     * @return User|false
     */
    public function register()
    {
        if (!$this->validate()) {
            return false;
        }
        
        $user = new User();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->status = User::STATUS_ENABLED;
        $user->setPassword($this->password);
        
        if ($this->userRegisterEvent($user) && $user->save()) {
            return $user;
        }
        
        return false;
    }
    
    /**
     * This method is called before register a user.
     * @param User $user
     * @return boolean
     */
    protected function userRegisterEvent(User $user)
    {
        $event = new UserEvent([
            'identity' => $user,
        ]);
        $this->trigger(self::EVENT_REGISTER, $event);
        
        return $event->isValid;
    }
    
}
