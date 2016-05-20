<?php
/**
 * @author Skorobogatko Alexei <skorobogatko.oleksii@gmail.com>
 * @copyright 2016
 * @version $Id$
 */

namespace app\widgets;

use Yii;
use yii\helpers\Html;
use app\helpers\Icon;

/**
 * GridView compatible with AdminLTE theme.
 *
 * @author skoro
 */
class GridView extends \yii\grid\GridView
{
    
    /**
     * @var array the HTML attributes for the container tag of the grid view.
     * The "tag" element specifies the tag name of the container element and defaults to "div".
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = ['class' => 'box'];
    
    /**
     * @var array|false enabled tool buttons.
     */
    public $tools = ['create'];
    
    /**
     * @var array
     */
    public $toolButtons = [];
    
    /**
     * @var array tool buttons container options.
     */
    public $toolOptions = [];
    
    /**
     * @var array the HTML attributes for the caption element.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     * @see caption
     */
    public $captionOptions = ['class' => 'box-title'];
    
    /**
     * @var array the HTML attributes for the grid table element.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $tableOptions = ['class' => 'table table-bordered table-hover dataTable'];
    
    /**
     * @var array|boolean add action column.
     * @see app\base\grid\ActionColumn
     */
    public $actions = true;
    
    /**
     * @var string the layout that determines how different sections of the list view should be organized.
     */
    public $layout = "
        {caption}
        <div class='box-body'>
            <div class='row'>
                <div class='col-sm-12'>
                    {items}
                </div>
            </div>
            <div class='row'>
                <div class='col-sm-5'>
                    <div class='dataTables_info'> {summary} </div>
                </div>
                <div class='col-sm-7'>
                    <div class='dataTables_paginate paging_simple_numbers'> {pager} </div>
                </div>
            </div>
        </div>
    ";
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->actions) {
            $column = [
                'class' => 'app\base\grid\ActionColumn',
                'header' => 'Actions',
            ];
            if (is_array($this->actions)) {
                $column['buttons'] = $this->actions;
            }
            $this->columns[] = $column;
        }
        parent::init();
        $this->initDefaultToolButtons();
    }
    
    /**
     * 
     */
    protected function initDefaultToolButtons()
    {
        $options = ['class' => 'btn btn-default btn-flat', 'data-pjax' => 0];
        if (empty($this->toolButtons['create'])) {
            $this->toolButtons['create'] = Html::a(Icon::PLUS . Yii::t('app', 'Create'), ['create'], $options);
        }
    }
    
    /**
     * @inheritdoc
     */
    public function renderSection($name)
    {
        if ($name === '{caption}') {
            return $this->renderCaption();
        }
        return parent::renderSection($name);
    }
    
    /**
     * @inheritdoc
     */
    public function renderItems()
    {
        $columnGroup = $this->renderColumnGroup();
        $tableHeader = $this->showHeader ? $this->renderTableHeader() : false;
        $tableBody = $this->renderTableBody();
        $tableFooter = $this->showFooter ? $this->renderTableFooter() : false;
        $content = array_filter([
            $columnGroup,
            $tableHeader,
            $tableFooter,
            $tableBody,
        ]);
        
        return Html::tag('table', implode("\n", $content), $this->tableOptions);
    }
    
    /**
     * Render table caption.
     */
    public function renderCaption()
    {
        if (empty($this->caption)) {
            return false;
        }
        $caption = Html::tag('h3', $this->caption, $this->captionOptions);
        $caption .= $this->renderToolButtons();
        return Html::tag('div', $caption, ['class' => 'box-header']);
    }
    
    /**
     * Render table tool buttons.
     * @return string
     */
    protected function renderToolButtons()
    {
        if ($this->tools) {
            $tools = '';
            foreach ($this->tools as $tool) {
                $tools .= $this->toolButtons[$tool];
            }
            Html::addCssClass($this->toolOptions, 'box-tools btn-group');
            return Html::tag('div', $tools, $this->toolOptions);
        }
        return '';
    }
    
}
