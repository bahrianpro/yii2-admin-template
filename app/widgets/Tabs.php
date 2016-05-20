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
 * AdminLTE compatible Tabs.
 * 
 * For example:
 * ```php
 * echo Tabs::widget([
 *     'header' => [
 *         'label' => 'Tabs header',
 *         'side' => Tabs::HEADER_RIGHT,
 *     ],
 *     'items' => [
 *         [
 *             'label' => 'One',
 *             'content' => 'Anim pariatur cliche...',
 *             'active' => true
 *         ],
 *     ],
 * ]);
 * ```
 *
 * @author skoro
 */
class Tabs extends \yii\bootstrap\Tabs
{
    /**
     * Header place side.
     */
    const HEADER_LEFT = 'pull-left';
    const HEADER_RIGHT = 'pull-right';

    /**
     * @var array tab header. Keys:
     * label - header label
     * side - header side: left or right (by default).
     */
    public $header = [];
    
    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();
        Html::removeCssClass($this->options, ['nav', $this->navType]);
        Html::addCssClass($this->options, 'nav-tabs-custom');
    }
    
    /**
     * Renders tab items as specified on [[items]].
     * @return string the rendering result.
     * @throws InvalidConfigException.
     */
    protected function renderItems()
    {
        $headers = [];
        $panes = [];

        if (!$this->hasActiveTab() && !empty($this->items)) {
            $this->items[0]['active'] = true;
        }

        foreach ($this->items as $n => $item) {
            if (!ArrayHelper::remove($item, 'visible', true)) {
                continue;
            }
            if (!array_key_exists('label', $item)) {
                throw new InvalidConfigException("The 'label' option is required.");
            }
            $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
            $label = $encodeLabel ? Html::encode($item['label']) : $item['label'];
            $headerOptions = array_merge($this->headerOptions, ArrayHelper::getValue($item, 'headerOptions', []));
            $linkOptions = array_merge($this->linkOptions, ArrayHelper::getValue($item, 'linkOptions', []));

            if (isset($item['items'])) {
                $label .= ' <b class="caret"></b>';
                Html::addCssClass($headerOptions, ['widget' => 'dropdown']);

                if ($this->renderDropdown($n, $item['items'], $panes)) {
                    Html::addCssClass($headerOptions, 'active');
                }

                Html::addCssClass($linkOptions, ['widget' => 'dropdown-toggle']);
                if (!isset($linkOptions['data-toggle'])) {
                    $linkOptions['data-toggle'] = 'dropdown';
                }
                $header = Html::a($label, "#", $linkOptions) . "\n"
                    . Dropdown::widget(['items' => $item['items'], 'clientOptions' => false, 'view' => $this->getView()]);
            } else {
                $options = array_merge($this->itemOptions, ArrayHelper::getValue($item, 'options', []));
                $options['id'] = ArrayHelper::getValue($options, 'id', $this->options['id'] . '-tab' . $n);

                Html::addCssClass($options, ['widget' => 'tab-pane']);
                if (ArrayHelper::remove($item, 'active')) {
                    Html::addCssClass($options, 'active');
                    Html::addCssClass($headerOptions, 'active');
                }

                if (isset($item['url'])) {
                    $header = Html::a($label, $item['url'], $linkOptions);
                } else {
                    if (!isset($linkOptions['data-toggle'])) {
                        $linkOptions['data-toggle'] = 'tab';
                    }
                    $header = Html::a($label, '#' . $options['id'], $linkOptions);
                }

                if ($this->renderTabContent) {
                    $tag = ArrayHelper::remove($options, 'tag', 'div');
                    $panes[] = Html::tag($tag, isset($item['content']) ? $item['content'] : '', $options);
                }
            }

            $headers[] = Html::tag('li', $header, $headerOptions);
        }
        
        $itemOptions = ['class' => 'nav ' . $this->navType];
        
        if ($this->header) {
            if (!array_key_exists('label', $this->header)) {
                throw new InvalidConfigException("The 'label' option for header is required.");
            }
            $side = ArrayHelper::getValue($this->header, 'side', self::HEADER_RIGHT);
            $headerOptions = array_merge($this->headerOptions, ArrayHelper::getValue($this->header, 'options', []));
            Html::addCssClass($headerOptions, 'header');
            Html::addCssClass($headerOptions, $side == self::HEADER_RIGHT ? self::HEADER_LEFT : self::HEADER_RIGHT);
            $headers[] = Html::tag('li', $this->header['label'], $headerOptions);
            if ($side === self::HEADER_RIGHT) {
                $headers = array_reverse($headers);
                Html::addCssClass($itemOptions, 'pull-right');
            }
        }

        $tabContent = ($this->renderTabContent ? "\n" . Html::tag('div', implode("\n", $panes), ['class' => 'tab-content']) : '');
        $items = Html::tag('ul', implode("\n", $headers), $itemOptions);
        
        return Html::tag('div', $items . $tabContent, $this->options);
    }

}
