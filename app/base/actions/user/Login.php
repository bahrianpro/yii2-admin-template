<?php
/**
 * @author Skorobogatko Oleksii <skorobogatko.oleksii@gmail.com>
 * @copyright 2016
 * @version $Id$
 */

namespace app\base\actions\user;

use Yii;
use app\base\Action;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * User login action.
 *
 * @todo enable/disable social links.
 * @author skoro
 */
class Login extends Action
{
    
    /**
     * @var string class name for Login form.
     */
    public $modelClass = 'app\forms\Login';
    
    /**
     * @var string
     */
    public $view = 'login';
    
    /**
     * @var boolean Enable/disable user register link.
     */
    public $enableRegister = true;

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->controller->goBack();
        }
        
        $model = new $this->modelClass;
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                return $this->controller->goBack();
            }
        }
        
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        
        return $this->render([
            'model' => $model,
            'enableRegister' => $this->enableRegister,
        ]);
    }
    
}
