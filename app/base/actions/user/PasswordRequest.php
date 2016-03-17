<?php
/**
 * @author Skorobogatko Oleksii <skorobogatko.oleksii@gmail.com>
 * @copyright 2016
 * @version $Id$
 */

namespace app\base\actions\user;

use Yii;
use yii\base\Action;

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
    public $modelClass = 'app\forms\PasswordRequest';
    
    /**
     * @var string
     */
    public $view;
    
    /**
     * @inheritdoc
     */
    public function run()
    {
        $model = new $this->modelClass;
        
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if ($model->sendEmail()) {
                    Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');
                    return $this->controller->redirect(['user/login']);
                } else {
                    Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
                }
            }
        }
        
        $view = empty($this->view) ? 'passwordRequest' : $this->view;
        return $this->controller->render($view, [
            'model' => $model,
        ]);
    }
    
}
