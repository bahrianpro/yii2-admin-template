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
            $this->addFlash(self::FLASH_WARNING, Yii::t('app', 'There is no start page. Please create one.'));
            return $this->redirect(['create']);
        }
        return $this->render('view');
    }
    
    /**
     * Creates a new wiki page
     * @param integer $id parent page id
     */
    public function actionCreate($id = null)
    {
        $wiki = new \modules\wiki\models\Wiki();
        if (!empty($id)) {
            $parent = $this->findModel(\modules\wiki\models\Wiki::className(), $id);
            $wiki->parent_id = $parent->id;
        }
        
        $editor = new Editor($wiki);
        $editor->summary = Yii::t('app', 'Page created.');
        
        if ($this->updateWiki($editor)) {
            return $this->redirect(['view', 'id' => $editor->getWiki()->id]);
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
        $wiki = $this->findModel(\modules\wiki\models\Wiki::className(), $id);
        $editor = new Editor($wiki);
        
        if ($this->updateWiki($editor)) {
            return $this->redirect(['view', 'id' => $editor->getWiki()->id]);
        }
        
        return $this->render('update', [
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
    
    public function actionPreview()
    {
        $this->layout = false;
        $content = Yii::$app->request->post('content', '');
        return Yii::$app->formatter->asMarkdown($content);
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
            return $editor->load($post) ? $editor->save() : false;
        }
        return false;
    }
}
