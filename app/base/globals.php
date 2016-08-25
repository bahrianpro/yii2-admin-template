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
    
    if (!$params && !$language && isset($data[$message])) {
        return $data[$message];
    }
    
    $translated = Yii::t('app', $message, $params, $language);
    if (!$params && !$language) {
        $data[$message] = $translated;
    }
    
    return $translated;
}
