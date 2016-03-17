<?php
/**
 * @author Skorobogatko Oleksii <skorobogatko.oleksii@gmail.com>
 * @copyright 2016
 * @version $Id$
 */

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password_hash
 * @property string $reset_token
 * @property string $activate_token
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * User statuses.
     */
    const STATUS_DISABLED = 0;
    const STATUS_ENABLED = 1;
    const STATUS_PENDING = 2;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => false,
            ]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        // User model can be created from command line app where is no
        // user property exists.
        if (isset(Yii::$app->user)) {
            // Update logged_at field after user login.
            Yii::$app->user->on(\yii\web\User::EVENT_AFTER_LOGIN, function ($event) {
                $event->identity->touch('logged_at');
            });
        }
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'password_hash'], 'required'],
            [['status', 'created_at', 'logged_at'], 'integer'],
            [['name', 'email'], 'string', 'max' => 64],
            [['password_hash', 'reset_token', 'activate_token', 'auth_key'], 'string', 'max' => 255],
            ['email', 'unique'],
            ['email', 'email'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Yii::t('app', 'User name'),
            'email' => Yii::t('app', 'Email'),
            'password_hash' => Yii::t('app', 'Password'),
            'reset_token' => Yii::t('app', 'Reset token'),
            'activate_token' => Yii::t('app', 'Activate token'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created'),
            'updated_at' => Yii::t('app', 'Updated'),
        ];
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|integer $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }
    
    /**
     * Get user model by email.
     * @param string $email
     * @return User
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @return int current user ID
     */
    public function getId()
    {
        return (int) $this->id;
    }

    /**
     * @param string $authKey
     * @return boolean if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new \yii\base\Exception('Not implemented');
    }
    
    /**
     * Whether is the password valid ?
     * @param string $password
     * @return boolean
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
    
    /**
     * Generate password hash.
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
        return $this;
    }
    
    /**
     * Get human readable user status.
     * @param integer $status Optional. If missed all statuses returned.
     * @return array|string|null
     */
    public static function getStatus($status = null)
    {
        $statuses = [
            self::STATUS_DISABLED => Yii::t('app', 'Disabled'),
            self::STATUS_ENABLED => Yii::t('app', 'Enabled'),
            self::STATUS_PENDING => Yii::t('app', 'Pending'),
        ];
        return ($status === null) ? $statuses : isset($statuses[$status]) ? $statuses[$status] : null;
    }
    
    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key = Yii::$app->security->generateRandomString();
            }
            return true;
        }
        return false;
    }
    
    /**
     * Generate random token for password reset.
     * @return User
     */
    public function generatePasswordResetToken()
    {
        $this->reset_token = Yii::$app->security->generateRandomString() . '_' . time();
        return $this;
    }
    
    /**
     * Finds user by password reset token.
     * 
     * Expire of reset token adjusted by 'passwordResetTokenExpire' 
     * configuration parameter:
     * ```php
     *  'params' => [
     *      'passwordResetTokenExpire' => 3600, // 1 hour.
     *  ],
     * ```
     * 
     * @param string $token
     * @return User|null
     */
    public static function findByResetToken($token)
    {
        $expire = isset(Yii::$app->params['passwordResetTokenExpire']) ?
                (int) Yii::$app->params['passwordResetTokenExpire'] : 3600;
        
        // Is token expired ?
        $list = explode('_', $token);
        $time = (int) end($list);
        if ($time + $expire < time()) {
            return null;
        }
        
        return static::findOne([
            'reset_token' => $token,
            'status' => self::STATUS_ENABLED,
        ]);
    }
    
}
