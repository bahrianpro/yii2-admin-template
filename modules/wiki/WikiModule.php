<?php

namespace modules\wiki;

/**
 * wiki module definition class
 */
class WikiModule extends \app\base\Module
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
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
