<?php
/**
 * @author Skorobogatko Alexei <skorobogatko.oleksii@gmail.com>
 * @copyright 2016
 * @version $Id$
 */

namespace app\widgets;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * GridView compatible with AdminLTE theme.
 *
 * @author skoro
 */
class GridView extends \yii\grid\GridView
{
    
    /**
     * @var array grid bulk actions. Accepts following fields:
     * name - select input name
     * tag - html tag for bulk container
     * selectClass - select class widget (by default Select2)
     * selectOptions - array of options applicable for select widget
     * empty - empty item
     * items - items dropdown in key => value
     * options - bulk container options
     * submit - rendered button
     * submitLabel - label for bulk submit button
     * submitOptions - submit button options
     */
    public $bulk = [];
    
    /**
     * @var array bulk form options. Accepts following fields:
     * action - controller action accepts bulk data (by default current action)
     * method - request method (by default POST)
     * options - form options
     */
    public $bulkForm = [];
    
    /**
     * @var array bulk column class.
     */
    public $bulkColumn = [
        'class' => '\yii\grid\CheckboxColumn',
    ];
    
    /**
     * @var string
     * @inheritdoc
     */
    public $layout = "{summary}\n{items}\n{bulk}\n{pager}";
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->bulk) {
            array_unshift($this->columns, $this->bulkColumn);
        }
        parent::init();
    }
    
    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->bulk) {
            echo Html::beginForm(
                ArrayHelper::getValue($this->bulkForm, 'action'),
                ArrayHelper::getValue($this->bulkForm, 'method', 'POST'),
                ArrayHelper::getValue($this->bulkForm, 'options', [])
            );
        }
        
        parent::run();
        
        if ($this->bulk) {
            echo Html::endForm();
        }
    }
    
    /**
     * @inheritdoc
     */
    public function renderSection($name)
    {
        if ($name === '{bulk}') {
            return $this->renderBulk();
        }
        return parent::renderSection($name);
    }
    
    /**
     * Render bulk dropdown and submit.
     * @return string
     */
    public function renderBulk()
    {
        if (!$this->bulk) {
            return;
        }
        
        $items = ArrayHelper::remove($this->bulk, 'items', []);
        $defaults = [
            'name' => 'bulk',
            'tag' => 'div',
            'selectOptions' => [
                'fullWidth' => false,
            ],
            'empty' => 'Bulk action',
            'selectClass' => Select2::className(),
            'options' => ['class' => 'bulk pull-left'],
            'submitLabel' => 'Apply',
            'submitOptions' => ['class' => 'btn btn-flat btn-default'],
        ];
        $bulk = ArrayHelper::merge($defaults, $this->bulk);
        $selectOptions = $bulk['selectOptions'];
        $selectOptions['name'] = $bulk['name'];
        $selectOptions['items'] = $items;
        $selectOptions['empty'] = $bulk['empty'];
        
        $widget = $bulk['selectClass']::widget($selectOptions);
        
        if (isset($bulk['submit'])) {
            $submit = $bulk['submit'];
        } else {
            $submit = Html::submitButton($bulk['submitLabel'], $bulk['submitOptions']);
        }
        
        if (strpos($bulk['options']['class'], 'pull-left') !== false) {
            Html::addCssClass($this->pager['options'], 'pagination pull-right');
        }
        
        return Html::tag($bulk['tag'], $widget . $submit, $bulk['options']);
    }
}
