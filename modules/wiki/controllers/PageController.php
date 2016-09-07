<?php
/**
 * @author Skorobogatko Alexei <skorobogatko.oleksii@gmail.com>
 * @copyright 2016
 * @version $Id$
 * @since 0.2
 */

namespace modules\wiki\controllers;

use app\base\Controller;
use modules\wiki\forms\Editor;
use modules\wiki\models\History;
use modules\wiki\models\Wiki;
use Yii;
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
     * Wiki index.
     * Shows all root pages.
     */
    public function actionIndex()
    {
        $rootPages = Wiki::findAllRoot();
        
        return $this->render('index', [
            'rootPages' => $rootPages,
        ]);
    }
    
    /**
     * View wiki page.
     * @param integer $id wiki page id
     */
    public function actionView($id)
    {
        /** @var $wiki Wiki */
        $wiki = $this->findModel(Wiki::className(), $id);
        
        return $this->render('view', [
            'wiki' => $wiki,
        ]);
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
            $post = Yii::$app->request->post();
            if ($editor->load($post) && $editor->save()) {
                return $this->redirect(['page/view', 'id' => $editor->getWiki()->id]);
            }
        }
        
        return $this->render('create', [
            'editor' => $editor,
        ]);
    }
    
    /**
     * Update wiki page.
     * @param integer $id wiki page id
     * @param integer $rev history revision id
     */
    public function actionUpdate($id, $rev = null)
    {
        /** @var $wiki Wiki */
        $wiki = $this->findModel(Wiki::className(), $id);
        $editor = new Editor($wiki);
        
        if ($rev) {
            /** @var $history History */
            $history = History::findOne([
                'wiki_id' => $id,
                'rev' => $rev,
            ]);
            if (!$history) {
                $this->addFlash(self::FLASH_WARNING, Yii::t('app', 'Revision not found.'));
            }
            $editor->content = $history->content;
        }
        
        $historyProvider = new ActiveDataProvider([
            'query' => History::find()->where([
                'wiki_id' => $id,
            ])->orderBy('created_at DESC'),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);
        
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($editor->load($post) && $editor->save()) {
                return $this->redirect(['page/view', 'id' => $editor->getWiki()->id]);
            }
        }
        
        return $this->render('update', [
            'editor' => $editor,
            'historyProvider' => $historyProvider,
        ]);
    }
    
    /**
     * View raw markup.
     * @param integer $id wiki page id
     */
    public function actionRaw($id)
    {
        /** @var $wiki Wiki */
        $wiki = $this->findModel(Wiki::className(), $id);
        $this->layout = false;
        if ($history = $wiki->historyLatest) {
            print '<pre>' . $history->content . '</pre>';
        }
    }
    
    /**
     * Delete wiki page.
     * @param integer $id wiki page id
     */
    public function actionDelete($id)
    {
        /** @var $wiki Wiki */
        $wiki = $this->findModel(Wiki::className(), $id);
        
        return $this->render('delete', [
            'wiki' => $wiki,
        ]);
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
}
