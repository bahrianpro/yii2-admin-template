<?php
/**
 * @author Skorobogatko Alexei <skorobogatko.oleksii@gmail.com>
 * @copyright 2016
 * @version $Id$
 * @since 0.2
 */

namespace modules\wiki\controllers;

use app\base\Controller;
use modules\wiki\models\Wiki;
use Yii;

/**
 * Default controller for the `wiki` module
 */
class DefaultController extends Controller
{
    
    /**
     * View wiki page.
     * @param integer $id wiki page id, optional.
     */
    public function actionIndex($id = null)
    {
        if (empty($id)) {
            $wiki = Yii::$app->getModule('wiki')->getStartWiki();
            if (!$wiki) {
                $this->addFlash(self::FLASH_INFO, Yii::t('app', 'There is no start page. Please create one.'));
                return $this->redirect(['page/create']);
            }
        } else {
            /** @var $wiki Wiki */
            $wiki = $this->findModel(Wiki::className(), $id);
        }
        
        return $this->render('index', [
            'wiki' => $wiki,
        ]);
    }
}
