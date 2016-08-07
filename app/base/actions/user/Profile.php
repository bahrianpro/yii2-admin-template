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
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * User profile.
 *
 * @author skoro
 */
class Profile extends Action
{
    
    /**
     * @var string class name for Register form.
     */
    public $modelClass = 'app\forms\user\Profile';
    
    /**
     * @var string
     */
    public $view = 'profile';
    
    /**
     * @inheritdoc
     */
    public function run()
    {
        if (Yii::$app->user->isGuest) {
            return $this->controller->redirect(['user/login']);
        }
        
        $model = new $this->modelClass(Yii::$app->user->getIdentity());
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $this->controller->addFlash(Controller::FLASH_INFO, Yii::t('app', 'Changes saved.'));
                $model->reset();
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
