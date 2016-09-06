<?php
namespace modules\wiki;

use app\base\Module;

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
}
