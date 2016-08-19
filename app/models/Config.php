<?php
/**
 * @author Skorobogatko Oleksii <skorobogatko.oleksii@gmail.com>
 * @copyright 2016
 * @version $Id$
 * @since 0.2
 */

namespace app\models;

use app\components\Param;
use Yii;
use yii\base\InvalidParamException;
use yii\db\ActiveRecord;
use yii\validators\BooleanValidator;
use yii\validators\EmailValidator;
use yii\validators\NumberValidator;
use yii\validators\StringValidator;
use yii\validators\UrlValidator;

/**
 * This is the model class for table "config".
 *
 * @property integer $id
 * @property string $name
 * @property resource $value
 * @property string $value_type
 * @property string $desc
 * @property string $section
 */
class Config extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%config}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'string', 'max' => 255],
            
            ['value', 'validateValue', 'on' => ['default', 'update']],
            
            ['value_type', 'required'],
            ['value_type', 'string', 'max' => 8],
            
            ['desc', 'string'],
            ['desc', 'default', 'value' => ''],
            
            ['section', 'string', 'max' => 32],
            ['section', 'default', 'value' => Param::DEFAULT_SECTION],
            
            [['name', 'section'], 'unique', 'targetAttribute' => ['name', 'section'], 'message' => 'The combination of Name and Section has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'value' => 'Value',
            'value_type' => 'Value Type',
            'desc' => 'Desc',
            'section' => 'Section',
        ];
    }
    
    /**
     * Validate 'value' attribute against of 'value_type'.
     */
    public function validateValue($attribute, $params = [])
    {
        switch ($this->value_type) {
            case 'integer':
                $args = [
                    'class' => NumberValidator::className(),
                    'integerOnly' => true,
                ];
                break;
            
            case 'email':
                $args = [
                    'class' => EmailValidator::className(),
                ];
                break;
            
            case 'url':
                $args = [
                    'class' => UrlValidator::className(),
                ];
                break;
            
            case 'switch':
                $args = [
                    'class' => BooleanValidator::className(),
                ];
                break;
            
            case 'text':
                $args = [
                    'class' => StringValidator::className(),
                ];
                break;
            
            default:
                throw new InvalidParamException('Unknown config type: ' . $this->value_type);
        }
        
        $validator = Yii::createObject($args);
        if (!$validator->validate($this->$attribute)) {
            $this->addError($attribute, $validator->message);
        }
    }
    
    /**
     * @inheritdoc
     */
    public function afterFind()
    {
        $this->value = unserialize($this->value);
        // Force getDirtyAttributes() work with unserialized values.
        $this->setOldAttribute('value', $this->value);
        parent::afterFind();
    }
    
    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        $this->value = serialize($this->value);
        return parent::beforeSave($insert);
    }
}
