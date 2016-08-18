<?php
/**
 * @author Skorobogatko Oleksii <skorobogatko.oleksii@gmail.com>
 * @copyright 2016
 * @version $Id$
 */

namespace app\base\actions\user;

use Yii;
use app\base\Action;
use app\base\Controller;

/**
 * Request user password.
 *
 * @author skoro
 */
class PasswordRequest extends Action
{
    
    /**
     * @var string class name for Password Request form.
     */
    public $modelClass = 'app\forms\user\PasswordRequest';
    
    /**
     * @var string
     */
    public $view = 'passwordRequest';
    
    /**
     * @inheritdoc
     */
    public function run()
    {
        $model = new $this->modelClass;
        
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if ($model->sendEmail()) {
                    $this->controller->addFlash(Controller::FLASH_INFO, t('Check your email for further instructions.'));
                    return $this->controller->redirect(['user/login']);
                } else {
                    $this->controller->addFlash(Controller::FLASH_ERROR, t('Sorry, we are unable to reset password for provided email.'));
                }
            }
        }
        
        return $this->render([
            'model' => $model,
        ]);
    }
    
}
