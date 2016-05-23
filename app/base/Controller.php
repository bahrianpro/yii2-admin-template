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
    public function render($view, $params = [])
    {
        $_view = $this->getView();
        $_view->params['sidebarCollapsed'] = $this->getSidebarState();
        return parent::render($view, $params);
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
    protected function findModel($class, $id)
    {
        $model = call_user_func([$class, 'findOne'], $id);
        if (!$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return $model;
    }
    
}
