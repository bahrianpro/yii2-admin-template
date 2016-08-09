<?php
/**
 * @author Skorobogatko Alexei <skorobogatko.oleksii@gmail.com>
 * @copyright 2016
 * @version $Id$
 */

namespace app\base;

use app\widgets\ProgressBar;

/**
 * Formatter
 *
 * @author skoro
 */
class Formatter extends \yii\i18n\Formatter
{
    
    /**
     * Format value as progress bar widget.
     * @param integer $value progress value
     * @param array $options widget options
     * @return string
     */
    public function asProgressBar($value, $options = [])
    {
        $options['value'] = $value;
        return ProgressBar::widget($options);
    }
}
