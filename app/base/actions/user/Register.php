<?php
/**
 * @author Skorobogatko Oleksii <skorobogatko.oleksii@gmail.com>
 * @copyright 2016
 * @version $Id$
 */

namespace app\base\actions\user;

use Yii;
use yii\base\Action;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * User register action.
 *
 * @author skoro
 */
class Register extends Action
{
    
    /**
     * @var string class name for Register form.
     */
    public $modelClass = 'app\forms\Register';
    
    /**
     * @var string
     */
    public $view;
    
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
            if ($model->load(Yii::$app->request->post()) && $model->register()) {
                return $this->controller->goHome();
            }
        }
        
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        
        $view = empty($this->view) ? 'register' : $this->view;
        return $this->controller->render($view, [
            'model' => $model,
        ]);
    }

}
