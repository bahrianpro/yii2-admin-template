<?php
/**
 * @author Skorobogatko Oleksii <skorobogatko.oleksii@gmail.com>
 * @copyright 2016
 * @version $Id$
 */

namespace app\base;

use Yii;

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
        $this->sidebarState();
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
        $_view->params['sidebarCollapsed'] = $this->_sidebarCollapsed;
        return parent::render($view, $params);
    }
    
    /**
     * Check whether sidebar collapsed.
     */
    protected function sidebarState()
    {
        // Yii loads only crypted cookies on request, so we must use global COOKIE.  
        if (isset($_COOKIE['SidebarPushMenu']) && $_COOKIE['SidebarPushMenu'] === 'collapsed') {
            $this->_sidebarCollapsed = 'sidebar-collapse';
        }
    }
    
}
