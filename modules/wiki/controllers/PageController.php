<?php
/**
 * @author Skorobogatko Alexei <skorobogatko.oleksii@gmail.com>
 * @copyright 2016
 * @version $Id$
 * @since 0.2
 */

namespace modules\wiki\controllers;

use app\base\Controller;
use app\components\Param;
use modules\wiki\forms\Editor;
use modules\wiki\models\History;
use modules\wiki\models\Wiki;
use Yii;
use yii\base\Event;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;

/**
 * PageController
 *
 * @author skoro
 */
class PageController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'markdown-preview' => ['post'],
                ],
            ],
        ];
    }
    
    /**
     * Create root or child page.
     * @param integer $id wiki parent page id
     */
    public function actionCreate($id = null)
    {
        $wiki = new Wiki();
        if ($id) {
            /** @var $parent Wiki */
            $parent = $this->findModel(Wiki::className(), $id);
            $wiki->parent_id = $parent->id;
        }
        
        $editor = new Editor($wiki);
        $editor->summary = Yii::t('app', 'Page created.');
        
        if (Yii::$app->request->isPost) {
            if (empty($id)) {
                $editor->on(Editor::EVENT_AFTER_UPDATE, [$this, 'setStartPage']);
            }
            $post = Yii::$app->request->post();
            if ($editor->load($post) && $editor->save()) {
                return $this->redirect(['default/index', 'id' => $editor->getWiki()->id]);
            }
        }
        
        return $this->render('create', [
            'editor' => $editor,
        ]);
    }
    
    /**
     * Update wiki page.
     * @param integer $id wiki page id
     */
    public function actionUpdate($id)
    {
        /** @var $wiki Wiki */
        $wiki = $this->findModel(Wiki::className(), $id);
        $editor = new Editor($wiki);
        
        $historyProvider = new ActiveDataProvider([
            'query' => History::find()->where([
                'wiki_id' => $id,
            ])->orderBy('created_at DESC'),
        ]);
        
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($editor->load($post) && $editor->save()) {
                return $this->redirect(['default/index', 'id' => $editor->getWiki()->id]);
            }
        }
        
        return $this->render('update', [
            'editor' => $editor,
            'historyProvider' => $historyProvider,
        ]);
    }
    
    /**
     * Delete wiki page.
     * @param integer $id wiki page id
     */
    public function actionDelete($id)
    {
        
    }
    
    /**
     * Preview generated html from markdown text.
     * @return string
     */
    public function actionMarkdownPreview()
    {
        $this->layout = false;
        $content = Yii::$app->request->post('content', '');
        return Yii::$app->formatter->asMarkdown($content);
    }
    
    public function setStartPage(Event $event)
    {
        if (!($wiki = Yii::$app->getModule('wiki')->getStartWiki())) {
            /** @var $editor Editor */
            $editor = $event->sender;
            Param::update('Site.wikiStartPage', $editor->getWiki()->id);
            $this->addFlash(self::FLASH_INFO, Yii::t('app', 'This page will be default start page.'));
        }
    }
}
