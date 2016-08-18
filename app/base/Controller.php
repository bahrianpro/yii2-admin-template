<?php
/**
 * @author Skorobogatko Oleksii <skorobogatko.oleksii@gmail.com>
 * @copyright 2016
 * @version $Id$
 */

namespace app\base;

use Yii;
use yii\web\NotFoundHttpException;

/**
 * Controller
 *
 * @author skoro
 */
class Controller extends \yii\web\Controller
{

    /**
     * Flash keys used by Controller::addFlash().
     */
    const FLASH_ERROR = 'error';
    const FLASH_SUCCESS = 'success';
    const FLASH_DANGER = 'danger';
    const FLASH_INFO = 'info';
    const FLASH_WARNING = 'warning';
    
    /**
     * @var string when application sidebar is collapsed this contains collapsed css class.
     */
    protected $_sidebarCollapsed;
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->_sidebarCollapsed = $this->getSidebarState();
    }
    
    /**
     * @see Session::addFlash()
     */
    public function addFlash($key, $value, $removeAfterAccess = true)
    {
        Yii::$app->getSession()->addFlash($key, $value, $removeAfterAccess);
    }
    
    /**
     * @inheritdoc
     */
    public function renderContent($content)
    {
        $_view = $this->getView();
        $_view->params['sidebarCollapsed'] = $this->_sidebarCollapsed;
        return parent::renderContent($content);
    }
    
    /**
     * Gets sidebar collapsed state.
     * If sidebar is collapsed it returns collapsed css class.
     * @return string
     */
    protected function getSidebarState()
    {
        // Yii loads only crypted cookies on request, so we must use global COOKIE.  
        if (isset($_COOKIE['SidebarPushMenu']) && $_COOKIE['SidebarPushMenu'] === 'collapsed') {
            return 'sidebar-collapse';
        }
        return '';
    }
    
    /**
     * Finds a model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $class model class name with namespace.
     * @param integer $id
     * @return ActiveRecord
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function findModel($class, $id)
    {
        $model = call_user_func([$class, 'findOne'], $id);
        if (!$model) {
            $this->raise404();
        }
        return $model;
    }
    
    /**
     * Raise "Page not found" exception.
     * @param string $message
     * @throws NotFoundHttpException
     */
    public function raise404($message = 'The requested page does not exist.')
    {
        throw new NotFoundHttpException($message);
    }
    
    /**
     * Update a model based on POST request.
     * @param Model $model
     * @return boolean returns true when model validated and saved.
     */
    public function updateModel($model)
    {
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return true;
            }
        }
        return false;
    }
}
