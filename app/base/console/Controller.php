<?php
/**
 * @author Skorobogatko Alexei <a.skorobogatko@soft-industry.com>
 * @copyright 2016 Soft-Industry
 * @version $Id$
 */

namespace app\base\console;

use Yii;
use yii\helpers\Console;

/**
 * Controller
 * 
 * Parent for console controllers.
 *
 * @author skoro
 */
class Controller extends \yii\console\Controller
{
    
    /**
     * Prints translated message.
     * @param string $message
     * @param array $params
     */
    public function p($message, array $params = [])
    {
        $this->stdout(Yii::t('app', $message, $params) . PHP_EOL);
    }
    
    /**
     * Prints error message.
     * @param string $message
     * @param array $params
     */
    public function err($message, array $params = [])
    {
        $this->stderr(Yii::t('app', $message, $params) . PHP_EOL, Console::FG_RED);
    }
    
}
