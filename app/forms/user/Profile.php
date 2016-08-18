<?php
/**
 * @author Skorobogatko Alexei <skorobogatko.oleksii@gmail.com>
 * @copyright 2016
 * @version $Id$
 */

namespace app\forms\user;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * User Profile form.
 *
 * @author skoro
 */
class Profile extends Model
{
    
    /**
     * @var string 
     */
    public $name;
    
    /**
     * @var string
     */
    public $password;
    
    /**
     * @var string
     */
    public $password_repeat;
    
    /**
     * @var User
     */
    protected $user;
    
    /**
     * Creates a form model with given user.
     * @param User $user
     * @param array $config name-value pairs that will be used to initialize the object properties
     */
    public function __construct(User $user, $config = [])
    {
        $this->user = $user;
        $this->name = $user->name;
        parent::__construct($config);
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'string', 'min' => 3, 'max' => 64],
            ['name', 'filter', 'filter' => 'trim'],
            
            ['password', 'compare'],
            ['password', 'string', 'min' => 6, 'max' => 64],
            
            ['password_repeat', 'string', 'min' => 6, 'max' => 64],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => t('User name'),
            'password' => t('Password'),
            'password_repeat' => t('Confirm password'),
        ];
    }
    
    /**
     * Read only email property.
     * @return string
     */
    public function getEmail()
    {
        return $this->user->email;
    }
    
    /**
     * Save changes.
     * @return boolean
     */
    public function save()
    {
        if (!$this->validate()) {
            return false;
        }
        
        $this->user->name = $this->name;
        if (!empty($this->password)) {
            $this->user->setPassword($this->password);
        }
        
        return $this->user->save();
    }
    
    public function reset()
    {
        $this->name = $this->user->name;
        $this->password = '';
        $this->password_repeat = '';
    }
    
}
