<?php
/**
 * @author Skorobogatko Alexei <skorobogatko.oleksii@gmail.com>
 * @copyright 2016
 * @version $Id$
 */

namespace app\forms;

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
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'string', 'max' => 64],
            
            ['password', 'compare'],
            ['password', 'string', 'min' => 6, 'max' => 64],
        ];
    }
    
}
