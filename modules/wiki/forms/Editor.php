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
     * @var History
     */
    protected $_history;
    
    public function __construct($history = null, $config = array())
    {
        if ($history !== null && !$history instanceof History) {
            throw new \yii\base\InvalidValueException('history must be a History model instance.');
        }
        
        $this->_history = $history;
        
        if ($history !== null) {
            $this->title = $history->wiki->title;
            $this->slug = $history->wiki->slug;
            $this->content = $history->content;
        }
        
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
        
        if (!$this->isNew() && $this->content === $this->_history->content) {
            return $this->_history->wiki;
        }
        
        $transaction = Yii::$app->db->beginTransaction();
        
        try {
            $wiki = $this->isNew() ? new Wiki() : $this->_history->wiki;
            $wiki->title = $this->title;
            $wiki->slug = $this->slug;
            if (!$wiki->save()) {
                throw new \yii\db\Exception('Cannot save Wiki model.');
            }

            $history = new History();
            $history->wiki_id = $wiki->id;
            $history->content = $this->content;
            $history->host_ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
            $history->summary = $this->summary;
            if (!$history->save()) {
                throw new \yii\db\Exception('Cannot save History model.');
            }
            $this->_history = $history;
            
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }
        
        return $wiki;
    }
    
    public function isNew()
    {
        return $this->_history === null;
    }
    
    public function getHistory()
    {
        return $this->_history;
    }
}
