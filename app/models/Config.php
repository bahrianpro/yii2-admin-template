<?php
/**
 * @author Skorobogatko Oleksii <skorobogatko.oleksii@gmail.com>
 * @copyright 2016
 * @since 0.2
 */

namespace app\models;

use app\base\behaviors\SerializableBehavior;
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
 * @property array $perms
 */
class Config extends ActiveRecord
{
    
    /**
     * Config value types.
     */
    const TYPE_INT = 'integer';
    const TYPE_NUM = 'numeric';
    const TYPE_EMAIL = 'email';
    const TYPE_URL = 'url';
    const TYPE_SWITCH = 'switch';
    const TYPE_TEXT = 'text';
    const TYPE_EDITOR = 'editor';
    const TYPE_SELECT = 'select';
    const TYPE_PASSWORD = 'password';
    
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
    public function behaviors()
    {
        return [
            'serialize' => [
                'class' => SerializableBehavior::className(),
                'attributes' => ['value', 'options', 'perms'],
            ],
        ];
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

            ['value', 'validateValue', 'skipOnEmpty' => false],
            
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
            
            ['perms', 'safe'],
            ['perms', 'default', 'value' => ['updateSettings']],
        ];
    }

    /**
     * Validate 'value' attribute against of 'value_type'.
     */
    public function validateValue($attribute, $params = [])
    {
        if ($this->required) {
            $required = Yii::createObject([
                'class' => \yii\validators\RequiredValidator::className(),
                'message' => Yii::t('app', '{label} is required.', [
                    'label' => $this->title,
                ]),
            ]);
            if (!$required->validate($this->$attribute)) {
                $this->addError($attribute, $required->message);
                return;
            }
        } else {
            $value = $this->$attribute;
            if ($value === null || $value === '') {
                return;
            }
        }
        
        switch ($this->value_type) {
            case static::TYPE_INT:
                $args = [
                    'class' => NumberValidator::className(),
                    'integerOnly' => true,
                    'message' => 'Not an integer',
                ];
                break;
            
            case static::TYPE_NUM:
                $args = [
                    'class' => NumberValidator::className(),
                    'message' => 'Not a number',
                ];
                break;
            
            case static::TYPE_EMAIL:
                $args = [
                    'class' => EmailValidator::className(),
                    'message' => 'Not a valid email',
                ];
                break;
            
            case static::TYPE_URL:
                $args = [
                    'class' => UrlValidator::className(),
                    'message' => 'Not a valid url',
                ];
                break;
            
            case static::TYPE_SWITCH:
                $args = [
                    'class' => BooleanValidator::className(),
                    'message' => 'Must be boolean value',
                ];
                break;
            
            case static::TYPE_TEXT:
            case static::TYPE_EDITOR:
            case static::TYPE_PASSWORD:
                $args = [
                    'class' => StringValidator::className(),
                ];
                break;
            
            case static::TYPE_SELECT:
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
        } else {
            $this->castType();
        }
    }
    
    /**
     * Cast value to its type.
     */
    protected function castType()
    {
        switch ($this->value_type) {
            case static::TYPE_INT:
                $this->value = (int) $this->value;
                break;
            
            case static::TYPE_NUM:
                $this->value = (float) $this->value;
                break;
            
            case static::TYPE_SWITCH:
                $this->value = (boolean) $this->value;
                break;
        }
    }
}
