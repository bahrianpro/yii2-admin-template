<?php
/**
 * @author Skorobogatko Alexei <skorobogatko.oleksii@gmail.com>
 * @copyright 2016
 * @version $Id$
 * @since 0.2
 */

namespace app\base;

/**
 * Application module.
 *
 * @author skoro
 */
class Module extends \yii\base\Module
{
    /**
     * Module statuses.
     */
    const STATUS_INSTALLED = 1;
    const STATUS_NOTINSTALLED = 0;
    
    /**
     * @var string required, module name.
     */
    public $moduleName;

    /**
     * @var string
     */
    public $moduleDescription = '';
}
