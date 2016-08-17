<?php
/**
 * @author Skorobogatko Alexei <skorobogatko.oleksii@gmail.com>
 * @copyright 2016
 * @version $Id$
 */

namespace app\widgets;

use yii\helpers\Url;

/**
 * 
 *
 * @author skoro
 */
class Modal extends \yii\bootstrap\Modal
{
    
    /**
     * @var array|string
     */
    public $remote;
    
    /**
     * @inheritdoc
     */
    public function run()
    {
        parent::run();
        if ($this->remote) {
            $id = $this->options['id'];
            $url = Url::to($this->remote);
            $this->getView()->registerJs("Modal.remote('#$id', '$url');");
        }
    }
}
