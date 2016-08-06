<?php
/**
 * @author Skorobogatko Oleksii <skorobogatko.oleksii@gmail.com>
 * @copyright 2016
 * @version $Id$
 */

namespace app\forms\user;

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
    
    const EVENT_BEFORE_REGISTER = 'userBeforeRegister';
    const EVENT_AFTER_REGISTER = 'userAfterRegister';

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
     * @var integer
     */
    public $status;
    
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
            ['email', 'unique', 'targetClass' => User::className(), 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'compare'],
            ['password', 'string', 'min' => 6, 'max' => 64],
            
            ['password_repeat', 'required'],
            
            ['status', 'default', 'value' => User::STATUS_ENABLED],
            ['status', 'integer'],
            ['status', 'in',
                'range' => [User::STATUS_DISABLED, User::STATUS_ENABLED, User::STATUS_PENDING],
            ],
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
            'status' => Yii::t('app', 'Status'),
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
        $user->status = $this->status;
        $user->setPassword($this->password);
        
        if ($this->userRegisterEvent(self::EVENT_BEFORE_REGISTER, $user) &&
                $user->save()) {
            $this->userRegisterEvent(self::EVENT_AFTER_REGISTER, $user);
            return $user;
        }
        
        return false;
    }
    
    /**
     * This method generate user register event.
     * @param string $name event name.
     * @param User $user
     * @return boolean
     */
    protected function userRegisterEvent($name, User $user)
    {
        $event = new UserEvent([
            'identity' => $user,
        ]);
        $this->trigger($name, $event);
        
        return $event->isValid;
    }
    
}
