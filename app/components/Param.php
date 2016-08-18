<?php
/**
 * @author Skorobogatko Alexei <skorobogatko.oleksii@gmail.com>
 * @copyright 2016
 * @version $Id$
 * @since 0.2
 */

namespace app\components;

use app\models\Config;
use yii\base\Component;

/**
 * Param
 *
 * @author skoro
 */
class Param extends Component
{
    
    const DEFAULT_SECTION = 'Site';
    
    const EVENT_PARAM_GET = 'parameterGet';
    const EVENT_PARAM_UPDATE = 'parameterUpdate';
    
    protected static $cache = [];
    
    /**
     * Get parameter value.
     * @param string $param parameter name without prefixed section returns
     * all parameters matched by name. Parameter name with section (Site.adminEmail)
     * return only single parameter.
     * @param mixed $default
     * @return mixed
     */
    public static function value($param, $default = null)
    {
        if (isset(static::$cache[$param])) {
            return static::$cache[$param]->value;
        }
        
        if (!($config = static::getConfig($param))) {
            return $default;
        }
        
        static::$cache[$param] = $config;
        return $config->value;
    }
    
    public static function update($param, $value)
    {
        if (isset(static::$cache[$param])) {
            $config = static::$cache[$param];
        } else {
            $config = static::getConfig($param);
        }
        
        if (!$config) {
            throw new \yii\base\InvalidValueException('Cannot find config for parameter: ' . $param);
        }
        
        $config->value = $value;
        if (!$config->save()) {
            throw new \ErrorException('Cannot save config model for parameter: ' . $param);
        }
        
        static::$cache[$param] = $config;
        
        return $value;
    }
    
    public static function getConfig($param)
    {
        list ($section, $name) = static::parseParamName($param);
        
        return Config::findOne([
            'name' => $name,
            'section' => $section,
        ]);
    }
    
    public static function getConfigsBySection($section)
    {
        return Config::find()
                ->where([
                    'section' => $section,
                ])
                ->indexBy('id')
                ->all();
    }
    
    public static function getSections()
    {
        $rows = (new \yii\db\Query)
                ->from(Config::tableName())
                ->select('section')
                ->distinct()
                ->all();
        
        return array_map(function ($row) {
            return $row['section'];
        }, $rows);
    }
    
    public static function parseParamName($param)
    {
        $section = self::DEFAULT_SECTION;
        if (($pos = strpos($param, '.')) !== false) {
            $section = trim(substr($param, 0, $pos));
            $name = trim(substr($name, $pos + 1));
            if (!$section) {
                $section = self::DEFAULT_SECTION;
            }
        }
        return [$section, $name];
    }
}
