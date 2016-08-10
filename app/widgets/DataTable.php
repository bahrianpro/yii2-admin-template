<?php
/**
 * @author Skorobogatko Alexei <skorobogatko.oleksii@gmail.com>
 * @copyright 2016
 * @version $Id$
 */

namespace app\widgets;

use app\assets\DataTableAsset;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\bootstrap\BootstrapWidgetTrait;

/**
 * DataTable
 *
 * @link https://datatables.net/
 * @author skoro
 */
class DataTable extends GridView
{

    use BootstrapWidgetTrait;
    
    /**
     * @var array
     */
    public $options = ['class' => 'table table-striped table-bordered'];
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->layout = '{items}';
    }
    
    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->showOnEmpty || $this->dataProvider->getCount() > 0) {
            $content = preg_replace_callback("/{\\w+}/", function ($matches) {
                $content = $this->renderSection($matches[0]);

                return $content === false ? $matches[0] : $content;
            }, $this->layout);
        } else {
            $content = $this->renderEmpty();
        }
        
        if ($content) {
            DataTableAsset::register($this->getView());
            $this->registerPlugin('DataTable');
        }

        echo $content;
    }
    
    /**
     * Renders the data models for the grid view.
     */
    public function renderItems()
    {
        $caption = $this->renderCaption();
        $columnGroup = $this->renderColumnGroup();
        $tableHeader = $this->showHeader ? $this->renderTableHeader() : false;
        $tableBody = $this->renderTableBody();
        $tableFooter = $this->showFooter ? $this->renderTableFooter() : false;
        $content = array_filter([
            $caption,
            $columnGroup,
            $tableHeader,
            $tableFooter,
            $tableBody,
        ]);

        return Html::tag('table', implode("\n", $content), $this->options);
    }
}
