<?php
namespace modules\wiki;

use app\base\Module;
use Exception;
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
        $this->addMenu('main-nav', [
            ['label' => 'Wiki', 'icon' => 'fa fa-wikipedia-w', 'url' => '#', 'items' => [
                ['label' => 'Pages list', 'icon' => 'fa fa-file-text', 'url' => ['/wiki/page/index']],
            ]],
        ]);
    }
}
