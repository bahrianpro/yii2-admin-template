<?php

/**
 * @file global wrappers.
 */

/**
 * Wrapper for Yii::t() with category 'app'.
 * @param string $message
 * @param array $params
 * @param string $language
 */
function t($message, $params = [], $language = null)
{
    static $data = [];
    
    if (isset($data[$message])) {
        return $data[$message];
    }
    
    return $data[$message] = Yii::t('app', $message, $params, $language);
}