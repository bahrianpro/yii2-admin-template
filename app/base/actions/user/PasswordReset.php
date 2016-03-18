<?php
/**
 * @author Skorobogatko Alexei <skorobogatko.oleksii@gmail.com>
 * @copyright 2016
 * @version $Id$
 */

namespace app\base\actions\user;

use Yii;
use app\base\Action;

/**
 * User password reset.
 *
 * @author skoro
 */
class PasswordReset extends Action
{
    /**
     * @var string class name for Login form.
     */
    public $modelClass = 'app\forms\PasswordReset';
    
    /**
     * @var string
     */
    public $view = 'passwordReset';
    
    /**
     * @inheritdoc
     */
    public function run($token)
    {
        $session = Yii::$app->getSession();
        try {
            $model = new $this->modelClass($token);
        }
        catch(\yii\base\InvalidParamException $e) {
            $session->setFlash('error', $e->getMessage());
            return $this->controller->goHome();
        }
        
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if ($model->resetPassword()) {
                    $session->setFlash('success', Yii::t('app', 'Password has been changed. Now you may login.'));
                    return $this->controller->redirect(['user/login']);
                }
                else {
                    $session->setFlash('error', Yii::t('app', 'Unable to change password.'));
                }
            }
        }
        
        return $this->render([
            'model' => $model,
        ]);
    }
    
}
