<?php

namespace modules\wiki\controllers;

use app\base\Controller;
use app\components\Param;
use modules\wiki\forms\Editor;
use modules\wiki\models\History;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `wiki` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $page = Param::value('Site.wikiStartPage');
        if (!$page) {
            $this->redirect(['create']);
        }
        return $this->render('view');
    }
    
    public function actionCreate()
    {
        $editor = new Editor();
        
        /** @var $wiki \modules\wiki\models\Wiki */
        if (($wiki = $this->updateWiki($editor))) {
            return $this->redirect(['view', 'id' => $wiki->id]);
        }
        
        return $this->render('create', [
            'editor' => $editor,
        ]);
    }
    
    /**
     * Update a wiki page.
     * @param string $id wiki page id
     */
    public function actionUpdate($id)
    {
        $history = $this->getHistoryLatest($id);
        $editor = new Editor($history);
        
        /** @var $wiki \modules\wiki\models\Wiki */
        if (($wiki = $this->updateWiki($editor))) {
            return $this->redirect(['view', 'id' => $wiki->id]);
        }
        
        return $this->render('update', [
            'history' => $history,
            'editor' => $editor,
        ]);
    }
    
    /**
     * View a wiki page.
     * @param integer $id wiki page id
     */
    public function actionView($id)
    {
        $history = $this->getHistoryLatest($id);
        
        return $this->render('view', [
            'history' => $history,
        ]);
    }
    
    /**
     * Get latest history model.
     * @param integer $wikiId
     * @return Wiki
     * @throws NotFoundHttpException
     */
    protected function getHistoryLatest($wikiId)
    {
        $history = History::findOneLatest($wikiId);
        if (!$history) {
            throw new NotFoundHttpException();
        }
        return $history;
    }
    
    /**
     * Update wiki page with POST data.
     * @param Editor $editor
     * @return Wiki|false
     */
    protected function updateWiki(Editor $editor)
    {
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            /** @var $wiki \modules\wiki\models\Wiki */
            if ($editor->load($post) && ($wiki = $editor->save())) {
                return $wiki;
            }
        }
        return false;
    }
}
