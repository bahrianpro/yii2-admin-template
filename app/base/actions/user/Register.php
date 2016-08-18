<?php
/**
 * @author Skorobogatko Oleksii <skorobogatko.oleksii@gmail.com>
 * @copyright 2016
 * @version $Id$
 */

namespace app\base\actions\user;

use app\base\Action;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * User register action.
 *
 * To disable user registration, put to the app's config
 * parameter `disableUserRegister => true`.
 *
 * @author skoro
 */
class Register extends Action
{
    
    /**
     * @var string class name for Register form.
     */
    public $modelClass = 'app\forms\user\Register';
    
    /**
     * @var string
     */
    public $view = 'register';
    
    /**
     * @inheritdoc
     */
    public function run()
    {
        if (ArrayHelper::getValue(Yii::$app->params, 'disableUserRegister', false)) {
            throw new NotFoundHttpException();
        }
        
        if (!Yii::$app->user->isGuest) {
            return $this->controller->goBack();
        }
        
        $model = new $this->modelClass;
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->register()) {
                $this->controller->addFlash('info', t('Registration successful. Now you can <a href="{login}">login</a>.', ['login' => Url::to(['user/login'])]));
                return $this->controller->goHome();
            }
        }
        
        if (!Yii::$app->request->isPjax && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        
        return $this->render([
            'model' => $model,
        ]);
    }

}
