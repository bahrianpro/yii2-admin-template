<?php
/**
 * @author Skorobogatko Alexei <skorobogatko.alexei@gmail.com>
 * @copyright 2016
 * @version $Id$
 */

namespace app\base;

/**
 * Controller
 *
 * @author skoro
 */
class Controller extends \yii\web\Controller
{

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->initMenu();
    }
    
    /**
     * Initialize application menu.
     */
    protected function initMenu()
    {
        \Yii::$app->menu
                ->clearItems('main')
                ->addItems('main', [
                    ['label' => 'Development', 'icon' => 'fa fa-building-o', 'url' => '#', 'items' => [
                        ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['gii']],
                        ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['debug']],
                    ], 'guest' => false],
                    ['label' => 'Login', 'url' => ['user/login'], 'icon' => 'fa fa-sign-in', 'guest' => true],
                    ['label' => 'Register', 'url' => ['user/register'], 'icon' => 'fa fa-user-plus', 'guest' => true],
                    ['label' => 'Logout', 'url' => ['user/logout'], 'icon' => 'fa fa-sign-out', 'guest' => false],
                ])
                ->setTitle('main', 'Administration');
    }
    
}
