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
use yii\validators\RangeValidator;
use yii\validators\StringValidator;
use yii\validators\UrlValidator;

/**
 * This is the model class for table "config".
 *
 * @property integer $id
 * @property string $name
 * @property resource $value
 * @property string $value_type
 * @property string $options
 * @property string $title
 * @property string $desc
 * @property string $section
 * @property boolean $required
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
            
            ['title', 'required'],
            ['title', 'string', 'max' => 255],

            ['value', 'required', 'when' => function ($model) {
                return $model->required == true;
            }],
            ['value', 'validateValue'],
            
            ['value_type', 'required'],
            ['value_type', 'string', 'max' => 8],
            
            ['desc', 'string'],
            ['desc', 'default', 'value' => ''],
                    
            ['options', 'safe'],
            
            ['section', 'string', 'max' => 32],
            ['section', 'default', 'value' => Param::DEFAULT_SECTION],
            
            ['required', 'boolean'],
            ['required', 'default', 'value' => false],
            
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
                    'message' => 'Not a number',
                ];
                break;
            
            case 'email':
                $args = [
                    'class' => EmailValidator::className(),
                    'message' => 'Not a valid email',
                ];
                break;
            
            case 'url':
                $args = [
                    'class' => UrlValidator::className(),
                    'message' => 'Not a valid url',
                ];
                break;
            
            case 'switch':
                $args = [
                    'class' => BooleanValidator::className(),
                    'message' => 'Must be boolean value',
                ];
                break;
            
            case 'text':
            case 'editor':
                $args = [
                    'class' => StringValidator::className(),
                ];
                break;
            
            case 'select':
                $args = [
                    'class' => RangeValidator::className(),
                    'range' => array_keys($this->options),
                    'message' => 'Invalid value',
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
        $this->options = unserialize($this->options);
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
        $this->options = serialize($this->options);
        return parent::beforeSave($insert);
    }
    
    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        $this->value = unserialize($this->value);
        $this->options = unserialize($this->options);
        parent::afterSave($insert, $changedAttributes);
    }
}
