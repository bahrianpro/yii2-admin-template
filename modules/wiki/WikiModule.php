<?php

namespace modules\wiki;

use app\base\Module;
use app\components\Param;

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
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
    
    /**
     * @return Wiki|false
     */
    public function getStartWiki()
    {
        $id = Param::value('Site.wikiStartPage');
        return models\Wiki::findOne($id);
    }
}
