<?php
/**
 * @author Skorobogatko Alexei <skorobogatko.oleksii@gmail.com>
 * @copyright 2016
 * @version $Id$
 * @since 0.2
 */

namespace modules\wiki\forms;

use modules\wiki\models\History;
use modules\wiki\models\Wiki;
use Yii;
use yii\base\Model;

/**
 * Editor
 *
 * @author skoro
 */
class Editor extends Model
{
    
    /**
     * @var string
     */
    public $title;
    
    /**
     * @var string
     */
    public $slug;
    
    /**
     * @var string
     */
    public $content;
    
    /**
     * @var string
     */
    public $summary;
    
    /**
     * @var Wiki
     */
    protected $_wiki;
    
    public function __construct(Wiki $wiki, $config = array())
    {
        $this->_wiki = $wiki;
        $this->title = $wiki->title;
        $this->slug = $wiki->slug;
        
        $this->content = $this->getHistoryContent();
        
        parent::__construct($config);
    }
    
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['title', 'required'],
            ['title', 'string', 'max' => 255],
            ['title', 'filter', 'filter' => 'strip_tags'],
            ['title', 'filter', 'filter' => 'trim'],
            
            ['slug', 'string', 'max' => 255],
            
            ['summary', 'string', 'max' => 255],
            ['summary', 'default', 'value' => ''],
            
            ['content', 'string'],
        ];
    }
    
    /**
     * Validate and save wiki page.
     * @return Wiki|false
     */
    public function save()
    {
        if (!$this->validate()) {
            return false;
        }
        
        $transaction = Yii::$app->db->beginTransaction();
        
        try {
            $this->_wiki->title = $this->title;
            $this->_wiki->slug = $this->slug;
            if (!$this->_wiki->save()) {
                throw new \yii\db\Exception('Cannot save Wiki model.');
            }

            $history = new History();
            $history->wiki_id = $this->_wiki->id;
            $history->content = $this->content;
            $history->host_ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
            $history->summary = $this->summary;
            if (!$history->save()) {
                throw new \yii\db\Exception('Cannot save History model.');
            }
            
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }
        
        return $this->_wiki;
    }
    
    public function isNew()
    {
        return $this->_wiki->isNewRecord;
    }
    
    public function getWiki()
    {
        return $this->_wiki;
    }
    
    public function getHistoryContent()
    {
        $history = $this->_wiki->historyLatest;
        return $history ? $history->content : '';
    }
}
