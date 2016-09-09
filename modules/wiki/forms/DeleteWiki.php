<?php
/**
 * @author Skorobogatko Alexei <skorobogatko.oleksii@gmail.com>
 * @copyright 2016
 * @version $Id$
 * @since 0.2
 */

namespace modules\wiki\forms;

use modules\wiki\models\Wiki;
use Yii;
use yii\base\Model;

/**
 * Description of DeletePage
 *
 * @author skoro
 */
class DeleteWiki extends Model
{
    
    /**
     * Delete modes of how to delete children.
     */
    const DELETE_CHILDREN = 1; // delete all children
    const DELETE_MOVEUP = 2; // move children to one level up
    const DELETE_MOVEID = 3; // move to specific page
    
    /**
     * @var integer
     */
    public $mode;
    
    /**
     * @var integer
     */
    public $parentId;
    
    /**
     * @var Wiki
     */
    protected $_wiki;
    
    public function __construct(Wiki $wiki, $config = [])
    {
        $this->_wiki = $wiki;
        parent::__construct($config);
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['mode', 'required'],
            ['mode', 'integer'],
            ['mode', 'in', 'range' => [
                self::DELETE_CHILDREN, self::DELETE_MOVEUP, self::DELETE_MOVEID,
            ]],
            
            ['parentId', 'integer'],
            ['parentId', 'exist',
                'when' => function ($model) {
                    return $model->parentId;
                },
                'targetClass' => Wiki::className(),
                'targetAttribute' => ['parentId' => 'id'],
            ],
        ];
    }
    
    /**
     * @return Wiki
     */
    public function getWiki()
    {
        return $this->_wiki;
    }
    
    /**
     * @return boolean
     */
    public function isChildrenExists()
    {
        return (bool) $this->_wiki->getChildren()->count();
    }
    
    /**
     * @return Wiki[]
     */
    public function getChildren()
    {
        return $this->_wiki->children;
    }
    
    /**
     * Returns list of available delete choices.
     * @return array
     */
    public function getChoices()
    {
        $choices = [
            self::DELETE_CHILDREN => Yii::t('app', 'Delete also'),
        ];
        if ($parent = $this->_wiki->parent) {
            $choices[self::DELETE_MOVEUP] = Yii::t('app', 'Move these pages to "{title}"', [
                'title' => $parent->title,
            ]);
        }
        $choices[self::DELETE_MOVEID] = Yii::t('app', 'Move to selected:');
        return $choices;
    }
    
    /**
     * Delete page.
     * @return boolean
     */
    public function delete()
    {
        if (!$this->validate()) {
            return false;
        }
        
        if ($this->mode == self::DELETE_CHILDREN) {
            
        }
    }
}
