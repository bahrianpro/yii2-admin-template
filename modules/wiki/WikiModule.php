<?php
namespace modules\wiki;

use app\base\Module;
use app\components\Param;
use Yii;

/**
 * wiki module definition class
 */
class WikiModule extends Module
{
    /**
     * @var string required, module name.
     */
    public $moduleName = 'Wiki';

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'modules\wiki\controllers';
    
    /**
     * @inheritdoc
     */
    public $defaultRoute = 'page/index';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        // custom initialization code goes here
    }
    
    /**
     * @inheritdoc
     */
    public function install()
    {
        $this->installRoles();
        parent::install();
    }
    
    /**
     * @inheritdoc
     */
    public function uninstall()
    {
        $this->installRoles(true);
        parent::uninstall();
    }
    
    /**
     * Add/remove wiki roles to User.defaultRole system parameter.
     * @param boolean $uninstall remove roles instead adding.
     */
    protected function installRoles($uninstall = false)
    {
        $roleNames = ['WikiAdmin', 'WikiEditor'];
        if ($config = Param::getConfig('User.defaultRole')) {
            foreach ($roleNames as $name) {
                // Only check that role is exists on adding role to list.
                $role = Yii::$app->authManager->getRole($name);
                $options = $config->options;
                if ($uninstall && isset($options[$name])) {
                    unset($options[$name]);
                } elseif (!$uninstall && $role && !isset($options[$name])) {
                    $options[$name] = $name;
                }
                $config->options = $options;
            }
            $config->save();
        }
    }
}
