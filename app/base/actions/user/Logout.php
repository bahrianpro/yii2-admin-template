<?php
/**
 * @author Skorobogatko Oleksii <skorobogatko.oleksii@gmail.com>
 * @copyright 2016
 * @version $Id$
 */

namespace app\base\actions\user;

use Yii;
use app\base\Action;

/**
 * User logout action.
 *
 * @author skoro
 */
class Logout extends Action
{
    
    /**
     * @inheritdoc
     */
    public function run()
    {
        Yii::$app->user->logout();
        return $this->controller->goHome();
    }
    
}
