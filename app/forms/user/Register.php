<?php
/**
 * @author Skorobogatko Oleksii <skorobogatko.oleksii@gmail.com>
 * @copyright 2016
 * @version $Id$
 */

namespace app\forms\user;

use app\models\User;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\UserEvent;

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
            'name' => t('User name'),
            'email' => t('Email'),
            'password' => t('Password'),
            'password_repeat' => t('Confirm password'),
            'status' => t('Status'),
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
            $this->assignDefaultRole($user);
            $this->userRegisterEvent(self::EVENT_AFTER_REGISTER, $user);
            return $user;
        }
        
        return false;
    }
    
    /**
     * Assign default role to user.
     * @param User $user
     * @return boolean
     */
    protected function assignDefaultRole(User $user)
    {
        $auth = Yii::$app->authManager;
        
        $roleName = \app\components\Param::value('User.defaultRole');
        if (!$roleName) {
            return false;
        }
        
        if (!($role = $auth->getRole($roleName))) {
            Yii::warning('Cannot find role: ' . $roleName);
            return false;
        }
        
        $auth->assign($role, $user->id);
        return true;
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
